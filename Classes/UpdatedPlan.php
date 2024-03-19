<?php
require './Classes/Connection.php';
class UpdatedPlan
{
    public function setDataPlan($spreadsheetId, $range, $valueInputOption, $credenciais)
    {
        $connection = new Connection();
        $db = $connection->execConnection();
        $consult = $db->query("SELECT * FROM olyra_v4");
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
                $datas =  $this->ajustaDados($linha);
                $created_at =  $datas['created_at'];
                $nome = $datas['nome'];
                $email = $datas['email'];
                $telefone = $datas['telefone'];
                $message = $datas['mensagem'];
                $utm_medium = $datas[0]['utm_medium'];
                $utm_campaign = $datas[0]['utm_campaign'];
                $utm_term = $datas[0]['utm_term'];
                $utm_content = $datas[0]['utm_content'];
                $utm_source = $datas[0]['utm_source'];
                $utm_id =  $datas[0]['utm_id'];
                $gclid = $datas[0]['gclid'];
                $titulo_site = $datas['titulo_site'];

                if ($datas[0]['utm_term']) {
                    $datas = $datas[0]['utm_term'];
                    $dados[] = [
                        $created_at,
                        $titulo_site,
                        $nome,
                        $email,
                        $telefone,
                        $message,
                        $utm_medium,
                        $utm_campaign,
                        $utm_term,
                        $utm_content,
                        $utm_source,
                        $utm_id,
                        $gclid,
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

    private function ajustaDados($data)
    {
        $lead = json_decode($data['data'], true);
        $url = explode('URL_da_página', $lead['URL_da_página']);
        $utms = [
            'utm_source' => '',
            'utm_medium' => '',
            'utm_campaign' => '',
            'utm_term' => '',
            'utm_content' => '',
            'utm_id' => '',
            'gclid' => '',
        ];

        if (strpos($url[0], '?') === false) {
            $utms = [
                'utm_source' => 'Não preenchido',
                'utm_medium' => 'Não preenchido',
                'utm_campaign' => 'Não preenchido',
                'utm_term' => 'Não preenchido',
                'utm_content' => 'Não preenchido',
                'utm_id' => 'Não preenchido',
                'gclid' => 'Não preenchido',
            ];
        }

        if (strpos($url[0], '?') != false) {
            $utm = explode('?', $url[0]);
            $utm_separada = explode('&', $utm[1]);

            $utms = [
                'utm_source' => isset($utm_separada[0]) ? $utm_separada[0] : 'Não preenchido',
                'utm_medium' => isset($utm_separada[1]) ? $utm_separada[1] : 'Não preenchido',
                'utm_campaign' => isset($utm_separada[2]) ? $utm_separada[2] : 'Não preenchido',
                'utm_term' => isset($utm_separada[3]) ? $utm_separada[3] : 'Não preenchido',
                'utm_content' => isset($utm_separada[4]) ? $utm_separada[4] : 'Não preenchido',
                'utm_id' => isset($utm_separada[5]) ? $utm_separada[5] : 'Não preenchido',
                'gclid' => isset($utm_separada[6]) ? $utm_separada[6] : 'Não preenchido',
            ];
        }
        return [
            'created_at' => $lead['Data'],
            'nome' => $lead['Nome'],
            'telefone' => $lead['Telefone'],
            'email' => $lead['E-mail'],
            'mensagem' => $lead['Mensagem'],
            $utms,
            'titulo_site' => $lead['Sem_rótulo_titulo_site'] != '' ? $lead['Sem_rótulo_titulo_site'] : 'Nâo preenchido',
        ];
    }

    private function limpaCampos(){
        
    }
}
