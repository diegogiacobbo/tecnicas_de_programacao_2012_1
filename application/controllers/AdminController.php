<?php

@require_once ('negocio/AdminManager.php');
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
        $password = $this->getRequest()->getParam("password");
        $gerir_card = $this->getRequest()->getParam('gerir_card');
        $logout = $this->getRequest()->getParam('logout');

        if (isset($password)) {
            Zend_Registry::set('session', $session);
            $var = self::login($password, $nome_funcionario);
            if ($var) {
                $session->str_id = $nome_funcionario;
            } else {
                $this->view->err_log = "Usuário inválido!";
            }
        }

        if (isset($logout)) {
            self::logout();
        }

        /**
         *  SUPER 
         */
        if (isset($session->str_id)) {
            $this->view->str_log = "Logado como $session->str_id";

            /**
             *  @return botao logout
             */
            $router = new Zend_View_Helper_Url();
            $logout = $router->url(array(
                'controller' => 'Admin',
                'action' => 'index',
                'logout' => "out"));
            $this->view->logout = $logout;

            $gerir_card = $router->url(array(
                'controller' => 'Admin',
                'action' => 'cartao',
                'gerir_card' => "$session->str_id"));
            $this->view->gerir_card = $gerir_card;

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

    public static function login($password, $nome_funcionario) {
        $a = new Application_Model_Autentica();
        $user_id = $a->verificaFuncionario($nome_funcionario);
        return $a->autenticacao($user_id, $password);
    }

    public static function logout() {
        $session = new Zend_Session_Namespace('session');
        $session->unsetAll();
    }

    /**
     *      Criar um form pra cara botao  
     */
    public function resultAction() {
        $utilizacoes = $this->getRequest()->getParam('form_total_cartao');
        $tickets_pagos = $this->getRequest()->getParam('form_tickets_pago');
        $estadias = $this->getRequest()->getParam('form_utilizacao_card_func');
        $diames = $this->getRequest()->getParam('option');

        if (isset($utilizacoes)) {
            AdminManager::utilizacoesCartao();
        }
        if (isset($tickets_pagos)) {
            $this->view->result = AdminManager::ticketsPagos($diames);
        }
        if (isset($estadias)) {
            $this->view->result = AdminManager::totalPorEstadias($diames);
        }
    }

   
    
    
    public function cartaoAction() {
        $user = $this->getRequest()->getParam('gerir_card');
    }
}

