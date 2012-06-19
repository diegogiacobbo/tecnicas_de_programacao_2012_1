<?php

class AdminController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {



        $auth = new Application_Form_AuthFuncionario();
        $this->view->auth = $auth;
        
        echo $this->getRequest()->getParam("cartao");
//        var_dump($_POST);
        
    }

}

