<?php
require './Classes/Connection.php';
class UpdatedPlan
{
    public function setDataPlan($spreadsheetId, $range, $valueInputOption, $credenciais)
    {
        $connection = new Connection();
        $db = $connection->execConnection();
        $consult = $db->query("
           SELECT wpxmv.submission_id, wpxmv.key,wpxmv.value, wpxme.created_at FROM wpxm_e_submissions_values AS wpxmv inner join wpxm_e_submissions AS wpxme on wpxme.id = wpxmv.submission_id WHERE wpxmv.key IN('nome','message','email','telefone','utm_medium','utm_campaign','utm_term','utm_content','utm_source','utm_id','gclid') and wpxmv.value is not null and wpxme.created_at >= '2024-02-16 15:00' ORDER BY wpxmv.submission_id;
                            ");
        $dados = [];
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
        $contador = 0;
        $identifica_linha = 1;
        try {
            while ($linha = $consult->fetch(PDO::FETCH_ASSOC)) {
                if ($linha['key'] == 'nome' || $linha['key'] == 'name' && !empty($linha['value'])) {
                    $nome = $linha['value'] == '';
                }

                if ($linha['key'] == 'message' && !empty($linha['value'])) {
                    $message = $linha['value'];
                }

                if ($linha['key'] == 'email' && !empty($linha['value'])) {
                    if (filter_var($linha['value'], FILTER_VALIDATE_EMAIL)) {
                        $email = $linha['value'];
                    }
                }

                //Existe a validação pois o campo do formulário da olyra estava errado antes da criação do projeto
                if ($linha['key'] == 'email' && !empty($linha['value'])) {
                    if (is_numeric($linha['value'])) {
                        $telefone = $linha['value'];
                    }
                }

                if ($linha['key'] == 'telefone' && !empty($linha['value'])) {
                    $telefone = $linha['value'];
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

                if ($identifica_linha == 11) {
                    $dados[$contador] = [
                        $linha['created_at'],
                        $nome == '' ? 'Não Preenchido' : $nome,
                        $email == '' ? 'Não Preenchido' : $email,
                        $telefone == '' ? 'Não Preenchido' : $telefone,
                        $message == '' ? 'Não Preenchido' : $message,
                        $utm_medium == '' ? 'Não Preenchido' : $utm_medium,
                        $utm_campaign == '' ? 'Não Preenchido' : $utm_campaign,
                        $utm_term == '' ? 'Não Preenchido' : $utm_term,
                        $utm_content == '' ? 'Não Preenchido' : $utm_content,
                        $utm_source == '' ? 'Não Preenchido' : $utm_source,
                        $utm_id == '' ? 'Não Preenchido' : $utm_id,
                        $gclid == '' ? 'Não Preenchido' : $gclid
                    ];
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
                    $identifica_linha = 0;
                    $contador++;
                }
                $identifica_linha++;
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
