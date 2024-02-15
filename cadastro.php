<?php

require __DIR__ . '/vendor/autoload.php';
require './Classes/Credentials.php';
require './Classes/UpdatedPlan.php';

$credenciais = new Credentials();

$spreadsheetId = "1kI7waPuMCbf5ti2pSdHpTrh5ckM80hL9JRIu5yMX3AA";
$name_plan = date("d-m-Y");
$range = "{$name_plan}!A97";

$valueInputOption = "RAW";

$updatedPlan = new UpdatedPlan();
$updatedPlan->setDataPlan($spreadsheetId, $range, $valueInputOption, $credenciais);
