<?php
namespace Tualo\Office\AI\Checks;

use Tualo\Office\Basic\Middleware\Session;
use Tualo\Office\Basic\PostCheck;
use Tualo\Office\Basic\TualoApplication as App;


class Tables  extends PostCheck {
    
    public static function test(array $config){
        $clientdb = App::get('clientDB');
        if (is_null($clientdb)) return;
        $tables = [
            'open_ai_config'=>[
                'columns'=>[
                    'id'=>'varchar(36)'
                ]
            ],

        ];
        self::tableCheck('ai',$tables,
            "please run the following command: `./tm install-sql-ai --client ".$clientdb->dbname."`",
            "please run the following command: `./tm install-sql-ai --client ".$clientdb->dbname."`"

        );
    }
}