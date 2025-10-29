<?php

namespace Tualo\Office\AI\Routes;

use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route;
use Tualo\Office\Basic\IRoute;

use Orhanerday\OpenAi\OpenAi;

class Test extends \Tualo\Office\Basic\RouteWrapper
{

    public static function register()
    {

        Route::add('/ai/hello', function () {
            $db = App::get('session')->getDB();
            App::contenttype('application/json');
            try {

                $open_ai_key = App::configuration('openai', 'key');
                $open_ai = new OpenAi($open_ai_key);
                $chat = $open_ai->chat([
                    'model' => 'gpt-3.5-turbo',
                    'messages' => [

                        /*[
                            "role" => "system",
                            "content" => "You are a helpful assistant."
                        ],
                        */
                        [
                            "role" => "user",
                            "content" => 'Bitte bewerte den Schwierigkeitsgrad der Aufgabe, gibt dafür nur leicht, mittel oder schwer zurück: 
                            Welches drei der unten aufgeführten Begriffe sind **KEINE** typischen Ursachen für **kardiovaskuläre Erkrankungen**?
    
                            1. Alkoholkonsum
                            2. Alter
                            3. Bluthochdruck _(arterielle Hypertonie)_
                            *4. Depression
                            5. Diabetes
                            6. Erhöhter Cholesterinspiegel (Hypercholesterinämie)
                            *7. Glaukom
                            *8. Legasthenie
                            9. Rauchen
                            10. Übergewicht _(Adipositas)_ 
                        '
                        ],
                        /*
                        [
                            "role" => "user",
                            "content" => 'Bitte formuliere mir einen Begrüßungstext für ein Angebot zur Betreuung  einer Onlinewahl'
                        ],
                        
                        [
                            "role" => "assistant",
                            "content" => "The Los Angeles Dodgers won the World Series in 2020."
                        ],
                        [
                            "role" => "user",
                            "content" => "Where was it played?"
                        ],
                        */
                    ],
                    'temperature' => 1.0,
                    'max_tokens' => 4000,
                    'frequency_penalty' => 0,
                    'presence_penalty' => 0,
                ]);
                App::result('chat', json_decode($chat, true));
            } catch (\Exception $e) {
                App::result('msg', $e->getMessage());
            }
        }, array('get'), true);
    }
}
