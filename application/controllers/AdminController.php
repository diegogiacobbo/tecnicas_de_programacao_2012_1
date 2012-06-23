<?php

class AdminController extends Zend_Controller_Action {

    public function init() {
        /* Initialize action controller here */
    }

    public function indexAction() {

        require_once('Zend/Session.php');

        $session = new Zend_Session_Namespace('identity');

        $session->country = 'Australia';

        // output the value
        echo sprintf('Your country is %s', $session->country);

        // checking if a value is set
//        $hash = $this->getRequest()->getParam("csrf");
//        var_dump($_SESSION);
        $_SESSION["str_login"] = "";
        /**
         *  Botão logout 
         *  @return logout, view para o botão de sair da administração
         */
        $router = new Zend_View_Helper_Url();
        $logout = $router->url(array(
            'controller' => 'Admin',
            'action' => 'index',
            'logout' => "out"));
        $var = $this->getRequest()->getParam('logout');
        if (is_string($var))
            self::logout();

        /**
         *  @return $this->view->logado descrição de como está logado
         */
        if ($_SESSION["str_login"] != "Deslogado") {
            $this->view->logout = $logout;
            $id = $this->getRequest()->getParam("cartao");
            $logado = self::login($id);
            if (!is_array($logado)) {
                $_SESSION["str_login"] = $logado;
            } else if (isset($logado)) {
                $_SESSION["str_login"] = $logado[0]['descricao'] . "<br /><b>Tipo de cartão</b>" . "<br />Logado";
            }
        } else {
            $auth = new Application_Form_AuthFuncionario();
            $this->view->auth = $auth;
            $_SESSION["str_login"] = "Deslogado";
        }

        $this->view->logado = $_SESSION["str_login"];



//        var_dump($_SESSION);
    }

    public static function login($id) {

        $a = new Application_Model_Autentica();
        $array = array();
        $array = $a->autenticacao($id);
        if (isset($array)) {
            return $array;
        } else {
            return "Deslogado";
        }
    }

    public static function logout() {
        unset($_SESSION['id']);
        unset($_SESSION['descricao']);
        $_SESSION["str_login"] = "Deslogado";
    }

}

