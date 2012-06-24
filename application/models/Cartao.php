<?php

class Application_Model_Cartao {

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

