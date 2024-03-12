<?php
require './Classes/Connection.php';
class UpdatedPlan
{
    public function setDataPlan($spreadsheetId, $range, $valueInputOption, $credenciais)
    {
        $connection = new Connection();
        $db = $connection->execConnection();
        $consult = $db->query("SELECT wpxmv.submission_id,wpxmv.key,wpxmv.value, wpxme.created_at
            FROM wpxm_e_submissions_values AS wpxmv inner join wpxm_e_submissions AS wpxme on wpxme.id = wpxmv.submission_id 
            WHERE wpxmv.key IN('titulo_site','name','message','email','telefone','utm_medium','utm_campaign','utm_term','utm_content','utm_source','utm_id','gclid') 
            AND wpxme.created_at >= '2024-02-15 00:00:00' and wpxmv.value is not null order by wpxmv.submission_id, wpxmv.key desc LIMIT 12; 
        ");
        $dados = [];
        $created_at = "";
        $titulo_site = "";
        $nome = "";
        $email = "";
        $telefone = "";
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
                if ($linha['key'] == 'name') {
                    $nome = $linha['value'];
                }

                if ($linha['key'] == 'message') {
                    $message = $linha['value'];
                }

                if ($linha['key'] == 'email') {
                    if (filter_var($linha['value'], FILTER_VALIDATE_EMAIL)) {
                        $email = $linha['value'];
                    }
                }

                //Existe a validação pois o campo do formulário da olyra estava errado antes da criação do projeto
                if ($linha['key'] == 'email') {
                    if (is_numeric($linha['value'])) {
                        $telefone = $linha['value'];
                    }
                }

                if ($linha['key'] == 'telefone') {
                    $telefone = $linha['value'];
                }

                if ($linha['key'] == 'utm_medium') {
                    $utm_medium = $linha['value'];
                }

                if ($linha['key'] == 'utm_campaign') {
                    $utm_campaign = $linha['value'];
                }



                if ($linha['key'] == 'utm_content') {
                    $utm_content = $linha['value'];
                }

                if ($linha['key'] == 'utm_source') {
                    $utm_source = $linha['value'];
                }

                if ($linha['key'] == 'utm_id') {
                    $utm_id = $linha['value'];
                }

                if ($linha['key'] == 'gclid') {
                    $gclid = $linha['value'];
                }

                if ($linha['key'] == 'titulo_site') {
                    $titulo_site = $linha['value'];
                }

                $created_at = $linha['created_at'];

                if ($linha['key'] == 'utm_term') {
                    $utm_term = $linha['value'];
                    $dados[] = [
                        '' ? 'Não Preenchido' : $created_at,
                        '' ? 'Não Preenchido' : $titulo_site,
                        '' ? 'Não Preenchido' : $nome,
                        '' ? 'Não Preenchido' : $email,
                        '' ? 'Não Preenchido' : $telefone,
                        '' ? 'Não Preenchido' : $message,
                        '' ? 'Não Preenchido' : $utm_medium,
                        '' ? 'Não Preenchido' : $utm_campaign,
                        '' ? 'Não Preenchido' : $utm_term,
                        '' ? 'Não Preenchido' : $utm_content,
                        '' ? 'Não Preenchido' : $utm_source,
                        '' ? 'Não Preenchido' : $utm_id,
                        '' ? 'Não Preenchido' : $gclid,
                    ];
                    $created_at = "";
                    $titulo_site = "";
                    $nome = "";
                    $email = "";
                    $telefone = "";
                    $message = "";
                    $utm_medium = "";
                    $utm_campaign = "";
                    $utm_term = "";
                    $utm_content = "";
                    $utm_source = "";
                    $utm_id = "";
                    $gclid = "";
                    $titulo_site = "";
                }
            }


            $values = $dados;

            $data[] = new Google_Service_Sheets_ValueRange([
                'range' => $range,
                'values' => $values
            ]);

            $body = new Google_Service_Sheets_BatchUpdateValuesRequest([
                'valueInputOption' => $valueInputOption,
                'data' => $data
            ]);

            $result = $service->spreadsheets_values->batchUpdate($spreadsheetId, $body);
            printf("<h2 style='text-align:center; margin-top:100px'>Planilha Atualizada com Sucesso!!!</h2>");
            return $result;
        } catch (Exception $e) {
            echo '<pre>';
            echo 'Message: ' . $e->getMessage();
            echo '</pre>';
        }
    }
}
