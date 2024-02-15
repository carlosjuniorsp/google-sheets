<?php 
require './Classes/Connection.php';
class ConfigPlan{
    public function setConfig(){
        $connection = new Connection();
        $db = $connection->execConnection();
        $select_config = $db->prepare("SELECT * FROM config_sistem_sheets");
    }
}