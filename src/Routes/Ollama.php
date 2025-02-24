<?php
namespace Tualo\Office\AI\Routes;
use Tualo\Office\Basic\TualoApplication as App;
use Tualo\Office\Basic\Route;
use Tualo\Office\Basic\IRoute;

use Orhanerday\OpenAi\OpenAi;
use ArdaGnsrn\Ollama\Ollama;

class OllamaRoute implements IRoute{
    
    public static function register(){

        Route::add('/ol/test',function(){
            $db = App::get('session')->getDB();
            App::contenttype('application/json');
            try {

                $client = Ollama::client('http://host.docker.internal:11434');
                $response = $client->chat()->create([
                    'model' => 'llama3.2',

                    "stream"=> false,
                    
                    "format"=>[
                        "type"=> "object",
                        "properties"=> [
                        "reportnumber"=> [
                            "type"=> "string"
                        ],
                        "reportdate"=> [
                            "type"=> "string"
                        ],
                        "ordernumber"=> [
                            "type"=> "string"
                        ],
                        "currency"=> [
                            "type"=> "string"
                        ],
                        "gross"=> [
                            "type"=> "string"
                        ],
                        "net"=> [
                            "type"=> "string"
                        ],
                        "duedate"=> [
                            "type"=> "string"
                            ]
                        ],
                        "required" => [
                            "reportnumber",
                            "gross",
                            "reportdate",
                            "ordernumber",
                            "currency",
                            "net",
                            "duedate"
                        ],
                    ],
                    
                    'messages' => [
                        ['role' => 'user', 'content' => 'Ich benötige Informationen zu einer Rechnung.'],
                        ['role' => 'user', 'content' => 'Diese benötige ich im JSON Format mit folgdenen Rückgabefeldern.
                            - rechnungsnummer
                            - rechnungsdatum(reportdate) (im Format yyyy-mm-dd)
                            - referenznummer (wenn vorhanden)
                            - auftragsnummer (wenn vorhanden)
                            - währung (wenn vorhanden, im ISO 4217 Format, wenn nicht vorhanden, dann EUR)
                            - bruttobetrag(gross) (im Format 0.00)
                            - nettobetrag(net) (wenn vorhanden, im Format 0.00)
                            - zahlungsziel (wenn vorhanden, im Format yyyy-mm-dd)

                        '],
                        ['role' => 'user', 'content' => '
                                                                                                    Google Cloud EMEA Limited
                                                                                                                           Velasco
                                                                                                                 Clanwilliam Place

Rechnung                                                                                                                   Dublin 2
                                                                                                                            Ireland
Rechnungsnummer: 5100686663
                                                                                Umsatzsteuer-Identifikationsnummer: IE3668997OH



Rechnungsempfänger
Thomas Hoffmann
tualo solutions GmbH
Karl-Liebknecht-Straße 1d
07546 Gera
Germany
Umsatzsteuer-Identifikationsnummer: DE 263339944


Details                                                          Google Workspace
..............................................................
Rechnungsnummer                           5100686663
Rechnungsdatum
..............................................................
                                          31. Okt. 2024          Gesamtsumme in EUR                                   10,35 €
..............................................................
Abrechnungs-ID                            7086-7213-1451
..............................................................
Domainname                                tualo.de
                                                                 Übersicht für den Zeitraum 1. Okt. 2024 - 31. Okt. 2024


                                                                 Zwischensumme in EUR                                      10,35 €
                                                                 Umsatzsteuer (0%)                                          0,00 €
                                                                 Gesamtsumme in EUR                                        10,35 €

Dienste, die dem Reverse-Charge-Verfahren unterliegen - Für die Umsatzsteuer muss gemäß Artikel 196 der EU-Richtlinie 2006/112/EC
der Empfänger aufkommen.


Dein Konto wird automatisch mit dem fälligen Betrag belastet.




                                                                                                                     Seite 1 von 2
                     Rechnung                                                                   Rechnungsnummer: 5100686663




Abo                                              Beschreibung           Intervall                      Menge          Betrag (€)

Google Workspace Business Plus                   Vereinbarung           1. Okt. - 31. Okt.                  1             10,35

                                                                Zwischensumme in EUR                                    10,35 €
                                                                Umsatzsteuer (0%)                                         0,00 €


                                                                Gesamtsumme in EUR                                  10,35 €



   Du hättest gern zusätzliche Informationen zu den dir in Rechnung gestellten Gebühren? Detaillierte Erläuterungen findest
   du hier:
   https://support.google.com/a?p=gsuite-bills-and-charges




                                                                                                                   Seite 2 von 2                        
                        '],
                    ],
                ]);
                /*
                $completions = $client->completions()->create([
                    'model' => 'llama3.1',
                    'prompt' => 'Once upon a time',
                ]);
                */

                App::result('completions', $response->toArray() );
 
                
            }catch(\Exception $e){
                App::result('msg', $e->getMessage());
            }
        },array('get'),true);
    }
}