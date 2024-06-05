<?php
namespace Tualo\Office\AI\Commandline;
use Tualo\Office\Basic\ICommandline;
use Tualo\Office\Basic\CommandLineInstallSQL;

class Install extends CommandLineInstallSQL  implements ICommandline{
    public static function getDir():string {   return dirname(__DIR__,1); }
    public static $shortName  = 'ai';
    public static $files = [
        //'install/mail_config' => 'setup mail_config ',
        //'install/mail_config.ds' => 'setup mail_config.ds ',
        'install/addcommands' => 'setup addcommands ',
        'install/askAI' => 'setup askAI ',
        'install/askAIResult' => 'setup askAIResult ',

    ];
    
}