<?php
use Google\Client;
use Google\Service\Drive;
use Google\Service\Sheets;

require 'Classes/Credentials.php';

class Save
{
    public function __construct()
    {
    }

    public function batchUpdateValues($spreadsheetId, $range, $valueInputOption)
    {
        
        $client = new Google\Client;
        $client->useApplicationDefaultCredentials();
        $client->addScope(Google\Service\Drive::DRIVE);
        $service = new Google_Service_Sheets($client);
        $values = [
            ['NOME 1','telefone 1','menssagem 1'],
        ];
        try {

            $data[] = new Google_Service_Sheets_ValueRange([
                'range' => $range,
                'values' => $values
            ]);
            $body = new Google_Service_Sheets_BatchUpdateValuesRequest([
                'valueInputOption' => $valueInputOption,
                'data' => $data
            ]);
            $result = $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);
            printf("%d cells updated.", $result->getTotalUpdatedCells());
            return $result;
        } catch (Exception $e) {
            // TODO(developer) - handle error appropriately
            echo 'Message: ' . $e->getMessage();
        }
    }
}

new Save;
