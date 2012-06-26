<?php

class Application_Model_Ticket{

    public $id;
    public $data_entrada;
    public $data_saida;
    public $liberado;
    public $codigo;
    public $preco;

    public function Application_Model_Ticket() {
        
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDataEntrada() {
        return $this->data_entrada;
    }

    public function setDataEntrada($data_entrada) {
        $this->data_entrada = $data_entrada;
    }

    public function getDataSaida() {
        return $this->data_saida;
    }

    public function setDataSaida($data_saida) {
        $this->data_saida = $data_saida;
    }

    public function getLiberado() {
        return $this->liberado;
    }

    public function setLiberado($liberado) {
        $this->liberado = $liberado;
    }
    
     public function getPreco() {
        return $this->preco;
    }

    public function setPreco($preco) {
        $this->preco = $preco;
    }
    
    
    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
    }
    
    public function toString(){
        return " range [".$this->data_entrada." | ".$this->data_saida."] ";
    }

}

