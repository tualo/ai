<?php
namespace Tualo\Office\AI\Routes;
use Tualo\Office\Basic\TualoApplication;
use Tualo\Office\Basic\Route;
use Tualo\Office\Basic\IRoute;

use Orhanerday\OpenAi\OpenAi;
class Test implements IRoute{
    
    public static function register(){

        Route::add('/ai/hello',function(){
            $db = TualoApplication::get('session')->getDB();
            App::contenttype('application/json');
            try {

            $open_ai_key = App::configuration('openai','key');
            $open_ai = new OpenAi($open_ai_key);
            $chat = $open_ai->chat([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        "role" => "system",
                        "content" => "You are a helpful assistant."
                    ],
                    [
                        "role" => "user",
                        "content" => "Who won the world series in 2020?"
                    ],
                    [
                        "role" => "assistant",
                        "content" => "The Los Angeles Dodgers won the World Series in 2020."
                    ],
                    [
                        "role" => "user",
                        "content" => "Where was it played?"
                    ],
                ],
                'temperature' => 1.0,
                'max_tokens' => 4000,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ]);
            TualoApplication::result('chat',$chat);
 
                
            }catch(\Exception $e){
                echo $e->getMessage();
                exit();
                TualoApplication::result('msg', $e->getMessage());
            }
        },array('get','post'),false);
    }
}