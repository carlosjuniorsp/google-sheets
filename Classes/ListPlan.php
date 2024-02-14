<?php

require './Classes/Credentials.php';

class ListPlan
{
    public function listedPlan()
    {
        $credenciais = new Credentials();
        $client = new \Google_Client();
        $client->setApplicationName('google sheets v1 teste');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($credenciais->getCredencials());
        $client->setPrompt('select_account consent');

        $service = new Google_Service_Sheets($client);
    
        $range = "A2:U";
        $response = $service->spreadsheets_values->get($_ENV['ID_PLAN'], $range);
        return $response->getValues();
    }
}
