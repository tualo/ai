<?php
namespace Tualo\Office\AI\Routes;
use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route;
use Tualo\Office\Basic\IRoute;

use Orhanerday\OpenAi\OpenAi;
class AskAI implements IRoute{
    
    public static function register(){

        Route::add('/ai/askproc',function(){
            $db = App::get('session')->getDB();
            App::contenttype('application/json');
            try {

                $open_ai_key = App::configuration('openai','key');
                $open_ai = new OpenAi($open_ai_key);
                $payload = json_decode(@file_get_contents('php://input'),true);
                $db->direct('set @currentRequest = {payload}',['payload'=>json_encode($payload)]);
                $payload = @file_get_contents('php://input');
                $db->direct('call askAI(@currentRequest,@query)',[ ]);
                $v = $db->singleValue('select @query a',[ ],'a');
                $chat = $open_ai->chat([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [
                        [
                            "role" => "user",
                            "content" => $v
                        ],
                    ],
                    'temperature' => 1.0,
                    'max_tokens' => 4000,
                    'frequency_penalty' => 0,
                    'presence_penalty' => 0,
                ]);
                $chatResult = json_decode($chat,true);
                App::result('chat',$chatResult);
                $db->direct('set @result = {result}',['result'=>json_encode($chatResult)]);

                $db->direct('call askAIResult(@currentRequest,@result)',[ ]);
                App::result('success', true);

 
                
            }catch(\Exception $e){
                App::result('msg', $e->getMessage());
            }
        },array('post'),true);
    }
}