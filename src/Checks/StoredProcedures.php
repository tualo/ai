<?php

namespace Tualo\Office\AI\Checks;

use Tualo\Office\Basic\Middleware\Session;
use Tualo\Office\Basic\PostCheck;
use Tualo\Office\Basic\TualoApplication as App;


class StoredProcedures extends PostCheck {

    
    public static function test(array $config){
        $clientdb = App::get('clientDB');
        if (is_null($clientdb)) return;
        $def = [
            'askAI'=>'3c1a32b3abe38f0766fc492abdf90e11',
            'askAIResult'   => '3c1a32b3abe38f0766fc492abdf90e11',
            
        ];
        self::procedureCheck(
            'ai',
            $def,
            "please run the following command: `./tm install-sql-ai --client ".$clientdb->dbname."`",
            "please run the following command: `./tm install-sql-ai --client ".$clientdb->dbname."`"
        );
        
    }
}