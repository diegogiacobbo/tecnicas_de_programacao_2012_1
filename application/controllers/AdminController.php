<?php

class AdminController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $auth = new Application_Form_AuthFuncionario();
        $this->view->auth = $auth;

        $id = $this->getRequest()->getParam("cartao");

        $logado = "Deslogado";
//        $logado = self::login($id);
        $this->view->logado = $logado;
        
         $a = new Application_Model_Autentica($id);
                   var_dump($a->autenticacao($id));
   
                    
    }

    public static function login($id) {
        $a = new Application_Model_Autentica($id);
                    if ($a->autenticacao()) {
Zend_Session::setId($a->autenticacao());
            
            return "Logado";
        }
        return "Deslogado";
    }

    public static function logout() {
        Zend_Session::destroy();
    }

}

