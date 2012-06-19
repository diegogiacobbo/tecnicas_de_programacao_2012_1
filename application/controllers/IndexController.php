<?php

class IndexController extends Zend_Controller_Action {

    public function init() {

//		$uri = $this->_request->getPathInfo();
//              die($uri);
//		$activeNav = $this->view->navigation()->findByUri($uri);
//		$activeNav->active = true;
//        $funcionario = new Application_Model_Funcionario();
//        $this->view->entries = $funcionario->fetchAll();
    }

    public function indexAction() {


        $auth = new Application_Form_Auth();
        echo $auth;
        
//        $router = new Zend_View_Helper_Url();
//		echo $router->url(array(
//			'controller' => 'Admin',
//			'action' => 'index',
//			'id' => 25
//		));
    }

    public function pagamentoAction() {
        $id = $this->_getParam("ticket");
        if (isset($id)) {
            if (self::verificaTicket($id) == true) {
                Zend_Session::setId($id);
                echo "<br />validado!<br /><br />";
//                echo Zend_Session::getId();
                self::total();
            }else
                echo "Não existem ticket's com essa numeração!";
        }
    }

    public function aboutAction() {
        
    }

    public function sitemapAction() {

        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        echo $this->view->navigation()->sitemap();
    }

    public static function verificaTicket($id) {
        $ticket = new Application_Model_Ticket();
        $ticket = $ticket->fetchAll();

        foreach ($ticket as $key) {
            if ($id == $key['id']) {
                return true;
            }
        }
        return false;
    }

    public static function total() {
        $ticket = new Application_Model_Ticket();
        $ticket = $ticket->fetchAll();

        foreach ($ticket as $key) {
            if (Zend_Session::getId() == $key['id']) {

                $dt_entrada = new Zend_Date($key['data_entrada'], 'YYYY-mm-dd HH:mm:ss');
                $dt_saida = new Zend_Date($key['data_saida'], 'YYYY-mm-dd HH:mm:ss');

                echo $dt_entrada . "<br />";
                echo $dt_saida . "<br />";

                if (substr($dt_saida->getDay(), 0, -17) > substr($dt_entrada->getDay(), 0, 2)) {
                    (int) $date_diff = (int) substr($dt_saida->getDay(), 0, -17) - (int) substr($dt_entrada->getDay(), 0, 2);
                    echo "(R$ " . $date_diff * 50 . ")";
                } else {
                    (float) $hr_saida = floatval(substr($dt_saida->getHour(), -8, -6));
                    (float) $hr_entrada = floatval(substr($dt_entrada->getHour(), -8, -6));
                    (float) $min_saida = floatval(substr($dt_saida->getMinute(), -5, -3));
                    (float) $min_entrada = floatval(substr($dt_entrada->getMinute(), -5, -3));

                    (float) $date_diff = floatval($hr_saida - $hr_entrada) + floatval($min_saida - $min_entrada);

                    if ((float) (0.33) < (float) $date_diff && $date_diff <= 3) {
                        echo "(R$ 3,50) <br />";
                        echo $date_diff;
                    } else if ((float) $date_diff <= (float) (0.33)) {
                        echo "(R$ 0,00) <br />";
                        echo $date_diff;
                    } else if ($date_diff > 3) {
                        echo "(R$ 10,00) <br />";
                        echo $date_diff;
                    }
                }
//                $days = (($dateDiff / 24) / 24); //3600
                return (float) $date_diff;
            }
        }
    }

}

