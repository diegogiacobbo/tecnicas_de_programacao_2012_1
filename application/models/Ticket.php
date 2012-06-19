<?php

@require (APPLICATION_PATH . '/models/persistence/PDOConnectionFactory.php');
$db = new PDOConnectionFactory();

class Application_Model_Ticket extends Zend_Db_Table {

    protected $_name = "ticket";

}

