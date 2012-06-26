<?php

class Application_Model_Cartao {

    protected $id;
    protected $id_funcionario;
    protected $codigo;

    public function Application_Model_Cartao() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getIdFuncionario() {
        return $this->id_funcionario;
    }

    public function setIdFuncionario($id_funcionario) {
        $this->id_funcionario = $id_funcionario;
    }
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }

}

