<?php

@require (APPLICATION_PATH . '/models/persistence/PDOConnectionFactory.php');
$db = new PDOConnectionFactory();

class Application_Model_Cartao extends Zend_Db_Table {

    protected $_name = "cartao";
    public $id;
    public $descricao;

    public function Application_Model_Cartao() {
        
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getId() {
        return $this->id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

}

