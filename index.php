<!-- UIkit CSS -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.6.19/dist/css/uikit.min.css">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Olyra Sheets</title>
</head>

<body>
  <a href="cadastro.php">Cadastrar</a>
</body>

</html>
<?php

require './Classes/Credentials.php';

$credenciais = new Credentials();

require __DIR__ . '/vendor/autoload.php';

$client = new \Google_Client();
$client->setApplicationName('google sheets v1 teste');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig($credenciais->getCredencials());
$client->setPrompt('select_account consent');

$service = new Google_Service_Sheets($client);

$spreadsheetId = "1kI7waPuMCbf5ti2pSdHpTrh5ckM80hL9JRIu5yMX3AA"; //id da planilha

$range = "A2:U";
$response = $service->spreadsheets_values->get($spreadsheetId, $range);
$values = $response->getValues();

/***************************** */


?>

<div class="uk-container">
  <table class="uk-table uk-table-striped">
    <thead>
      <tr>
        <th>Nome</th>
        <th>Telefone</th>
        <th>E-mail</th>
        <th>Mensagem</th>
        <th>field_7a05365</th>
        <th>utm_source</th>
        <th>utm_medium</th>
        <th>utm_campaign</th>
        <th>utm_term</th>
        <th>utm_content</th>
        <th>utm_id</th>
        <th>gclid</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if (count($values) <= 0) {
        echo '<h1>Nenhum lead cadastrado no momento</h1>';
      } else {
        foreach ($values as $row) {
          echo '<td>' . $row[0] . '</td>';
          echo '<td>' . $row[1] . '</td>';
          echo '<td>' . $row[2] . '</td>';
      ?>
          <tr>
            <td> </td>
          </tr>
      <?php }
      }
      ?>
    </tbody>
  </table>
</div>