<?php

@require (APPLICATION_PATH . '/models/persistence/PDOConnectionFactory.php');
$db = new PDOConnectionFactory();

class Application_Model_Funcionario extends Zend_Db_Table {

    protected $_name = "funcionario";

}

