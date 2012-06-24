<?php

@require (APPLICATION_PATH . '/models/persistence/PDOConnectionFactory.php');

class Application_Model_Ticket extends Zend_Db_Table {

    protected $_name = "ticket";
    protected $id;
    protected $data_entrada;
    protected $data_saida;
    protected $liberado;

    public function Application_Model_Cartao() {
        
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

}

