<?php

require_once ('Zend/Loader.php');
require_once ('Zend/Session.php');

class AdminController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        $head = new Zend_View_Helper_HeadLink();
        $head->headLink()->appendStylesheet('/css/admin.css');

        Zend_Session::setOptions(array('save_path' => APPLICATION_PATH . '/sessions/'));
        Zend_Session::start();

        $session = new Zend_Session_Namespace('session');
        $session->setExpirationSeconds(3600);

        $this->view->err_log = "";

        $id = $this->getRequest()->getParam("cartao");
        $logout = $this->getRequest()->getParam('logout');
        $utilizacoes = $this->getRequest()->getParam('utilizacoes');
        $tickets_pagos = $this->getRequest()->getParam('tickets_pagos');
        $estadias = $this->getRequest()->getParam('estadias');


        if (isset($id)) {
            Zend_Registry::set('session', $session);
            if (self::login($id) == true) {
                $session->str_id = $id;
            } else {
                $this->view->err_log = "Cartão inválido!";
            }
        }

        if (isset($logout)) {
            self::logout();
        }

        if (isset($utilizacoes)) {
            self::utilizacoesCartao();
        }


        if (isset($tickets_pagos)) {
            self::ticketsPagos();
        }

        if (isset($estadias)) {
            self::valorPorEstadias();
        }


        /**
         *  SUPER 
         */
        if (isset($session->str_id)) {
            $this->view->str_log = "Cartão de @super usuário";

            /**
             *  @return botao logout
             */
            $router = new Zend_View_Helper_Url();
            $logout = $router->url(array(
                'controller' => 'Admin',
                'action' => 'index',
                'logout' => "out"));
            $this->view->logout = $logout;

            $estadias = $router->url(array(
                'controller' => 'Admin',
                'action' => 'index',
                'estadias' => "out"));
            $this->view->estadias = $estadias;

            $tickets_pagos = $router->url(array(
                'controller' => 'Admin',
                'action' => 'index',
                'tickets_pagos' => "out"));
            $this->view->tickets_pagos = $tickets_pagos;

            $utilizacoes = $router->url(array(
                'controller' => 'Admin',
                'action' => 'index',
                'utilizacoes' => "out"));
            $this->view->utilizacoes = $utilizacoes;
        }
        /**
         *  SEM PRIVILÉGIOS
         */ else {
            $this->view->str_log = "Sem privilégios";
            $auth = new Application_Form_AuthFuncionario();
            $this->view->auth = $auth;

            $this->view->logout = "";
            $this->view->estadias = "";
            $this->view->utilizacoes = "";
        }
    }

    public static function login($id) {
        $a = new Application_Model_Autentica();
        return $a->autenticacao($id);
    }

    public static function logout() {
        $session = new Zend_Session_Namespace('session');
        $session->unsetAll();
    }

    public static function utilizacoesCartao() {
        $histCartDao = new Application_Model_HistoricoCartaoDAO();
        $array_hcd = $histCartDao->Lista()->fetchAll(PDO::FETCH_CLASS, "Application_Model_HistoricoCartao");
        $array_hcd = reset($array_hcd);
        var_dump($array_hcd);
        foreach ($array_hcd as $data) {
//            echo "lagalaga". $data->getData()."</br>";
        }
    }

    public static function ticketsPagos() {
        $histCartDao = new Application_Model_TicketDAO();
        $array_hcd = $histCartDao->Lista()->fetchAll(PDO::FETCH_CLASS, "Application_Model_HistoricoCartao");
        $array_hcd = reset($array_hcd);
        var_dump($array_hcd);
    }

    public static function valorPorEstadias() {
        $histCartDao = new Application_Model_TicketDAO();
        $array_hcd = $histCartDao->Lista()->fetchAll(PDO::FETCH_CLASS, "Application_Model_HistoricoCartao");
        $array_hcd = reset($array_hcd);
        var_dump($array_hcd);
    }

}

