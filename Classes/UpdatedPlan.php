<?php
require './Classes/Connection.php';
class UpdatedPlan
{
    public function setDataPlan($spreadsheetId, $range, $valueInputOption, $credenciais)
    {
        $connection = new Connection();
        $db = $connection->execConnection();

        $consult = $db->query("SELECT wpxmv.id,wpxmv.key,wpxmv.value, wpxme.created_at FROM
                                wpxm_e_submissions_values AS wpxmv 
                                inner join wpxm_e_submissions AS wpxme 
                                on wpxme.id = wpxmv.submission_id 
                                WHERE wpxmv.key 
                                IN('nome','message','utm_medium','utm_campaign','utm_term','utm_content','utm_source','utm_id','gclid') 
                                and wpxme.created_at 
                                LIKE '%2024-02-14%' 
                                and wpxmv.value is not null 
                            ");

        $dados = [];
        $nome = "";
        $message = "";
        $utm_medium = "";
        $utm_campaign = "";
        $utm_term = "";
        $utm_content = "";
        $utm_source = "";
        $utm_id = "";
        $gclid = "";

        $client = new \Google_Client();
        $client->setApplicationName('olira');
        $client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
        $client->setAccessType('offline');
        $client->setAuthConfig($credenciais->getCredencials());
        $client->setPrompt('select_account consent');

        $service = new Google_Service_Sheets($client);

        try {
            while ($linha = $consult->fetch(PDO::FETCH_ASSOC)) {

                if ($linha['key'] == 'nome' && !empty($linha['value'])) {
                    $nome = $linha['value'] == '' ? 'em branco' : $linha['value'];
                }

                if ($linha['key'] == 'message' && !empty($linha['value'])) {
                    $message = $linha['value'];
                }

                if ($linha['key'] == 'utm_medium' && !empty($linha['value'])) {
                    $utm_medium = $linha['value'];
                }

                if ($linha['key'] == 'utm_campaign' && !empty($linha['value'])) {
                    $utm_campaign = $linha['value'];
                }

                if ($linha['key'] == 'utm_term' && !empty($linha['value'])) {
                    $utm_term = $linha['value'];
                }

                if ($linha['key'] == 'utm_content' && !empty($linha['value'])) {
                    $utm_content = $linha['value'];
                }

                if ($linha['key'] == 'utm_source' && !empty($linha['value'])) {
                    $utm_source = $linha['value'];
                }

                if ($linha['key'] == 'utm_id' && !empty($linha['value'])) {
                    $utm_id = $linha['value'];
                }

                if ($linha['key'] == 'gclid' && !empty($linha['value'])) {
                    $gclid = $linha['value'];
                }

                array_push($dados, [
                    $nome == '' ? 'Não Preenchido' : $nome,
                    $message == '' ? 'Não Preenchido' : $message,
                    $utm_medium == '' ? 'Não Preenchido' : $utm_medium,
                    $utm_campaign == '' ? 'Não Preenchido' : $utm_campaign,
                    $utm_term == '' ? 'Não Preenchido' : $utm_term,
                    $utm_content == '' ? 'Não Preenchido' : $utm_content,
                    $utm_source == '' ? 'Não Preenchido' : $utm_source,
                    $utm_id == '' ? 'Não Preenchido' : $utm_id,
                    $gclid == '' ? 'Não Preenchido' : $gclid
                ]);
            }

            $values =
                $dados;
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
            echo 'Message: ' . $e->getMessage();
        }
    }
}
