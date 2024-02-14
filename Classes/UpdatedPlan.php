<?php
require './Classes/Connection.php';
class UpdatedPlan
{
    public function setDataPlan($spreadsheetId, $range, $valueInputOption, $credenciais)
    {

        $connection = new Connection();
        $db = $connection->execConnection();

        $consult = $db->query("SELECT * from wpxm_e_submissions_values INNER JOIN wpxm_e_submissions ON wpxm_e_submissions_values.submission_id = wpxm_e_submissions.id WHERE wpxm_e_submissions_values.submission_id  = 6969 ");

        while ($linha = $consult->fetch(PDO::FETCH_ASSOC)) {
            echo "Key: {$linha['key']} - Nome: {$linha['value']} - Data de Cadastro: {$linha['created_at']}<br />";
        }
        // $client = new \Google_Client();
        // $client->setApplicationName('google sheets v1 teste');
        // $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        // $client->setAccessType('offline');
        // $client->setAuthConfig($credenciais->getCredencials());
        // $client->setPrompt('select_account consent');

        // $service = new Google_Service_Sheets($client);
        // $values = [
        //     ["Carlos", "11937061564", "carlos.junior@v4company.com", "Olá deu certo1"],

        // ];
        // try {

        //     $data[] = new Google_Service_Sheets_ValueRange([
        //         'range' => $range,
        //         'values' => $values
        //     ]);
        //     $body = new Google_Service_Sheets_BatchUpdateValuesRequest([
        //         'valueInputOption' => $valueInputOption,
        //         'data' => $data
        //     ]);
        //     $result = $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);
        //     printf("%d cells updated.", $result->getTotalUpdatedCells());
        //     return $result;
        // } catch (Exception $e) {
        //     echo 'Message: ' . $e->getMessage();
        // }
    }
}
