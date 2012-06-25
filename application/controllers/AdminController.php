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

        $nome_funcionario = $this->getRequest()->getParam("user");
        $id = $this->getRequest()->getParam("cartao");
        $logout = $this->getRequest()->getParam('logout');

        if (isset($id)) {
            Zend_Registry::set('session', $session);
            $nome_func = self::login($id, $nome_funcionario);
            if (is_string($nome_func)) {
                $session->str_id = $id;
                $session->tipo_user = $nome_func;
            } else {
                $this->view->err_log = "Cartão inválido!";
            }
        }

        if (isset($logout)) {
            self::logout();
        }

        /**
         *  SUPER 
         */
        if (isset($session->str_id)) {
            $this->view->str_log = "Cartão de @$session->tipo_user usuário";

            /**
             *  @return botao logout
             */
            $router = new Zend_View_Helper_Url();
            $logout = $router->url(array(
                'controller' => 'Admin',
                'action' => 'index',
                'logout' => "out"));
            $this->view->logout = $logout;

            $form_total_cartao = new Application_Form_TotalCartao();
            $this->view->form_total_cartao = $form_total_cartao;

            $form_tickets_pagos = new Application_Form_TicketsPago();
            $this->view->form_tickets_pagos = $form_tickets_pagos;
            
            $form_util_card_func = new Application_Form_UtilizacoesCartaoFuncionario();
            $this->view->form_util_card_func = $form_util_card_func;
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

    public static function login($id, $nome_funcionario) {
        $a = new Application_Model_Autentica();
        $user_id = $a->verificaFuncionario($nome_funcionario);
        return $a->autenticacao($id, $user_id);
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

    /**
     *      Criar um form pra cara botao  
     */
    public function resultAction() {
        $utilizacoes = $this->getRequest()->getParam('form_total_cartao');
        $tickets_pagos = $this->getRequest()->getParam('form_tickets_pago');
        $estadias = $this->getRequest()->getParam('form_utilizacao_card_func');
        
        
        $data_type = $this->getRequest()->getParam('date_type');

        if (isset($utilizacoes)) {
            self::utilizacoesCartao();
        }
        if (isset($tickets_pagos)) {
            self::ticketsPagos();
        }
        if (isset($estadias)) {
            self::valorPorEstadias();
        }
    }

}

