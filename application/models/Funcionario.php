<?php

class Application_Model_Funcionario extends Zend_Db_Table {

    protected $id;
    protected $nome;
    protected $password;

    public function Application_Model_Funcionario() {
        
    }
    
    public function getId(){
        return $this->id;
    }
    
    public function getNome(){
        return $this->nome;
        
    }
    public function setNome($nome){
        $this->nome = $nome;        
    }
    
    public function getPassword(){
        return $this->password;
        
    }
    public function setPassword($password){
        $this->password = $password;        
    }

}

