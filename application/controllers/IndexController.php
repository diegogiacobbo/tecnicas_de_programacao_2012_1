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
                echo Zend_Session::getId();
                echo self::total();
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

                $day1 = new Zend_Date($key['data_entrada'], 'YYYY-mm-dd HH:mm:ss');
                $day2 = new Zend_Date($key['data_saida'], 'YYYY-mm-dd HH:mm:ss');
                
//                if($day2->getDay() >=  $day1->getDay()){
                $dateDiff = $day2->getDate()->getHour() - $day1->getDate()->getDate()->getHour();
                
                echo $day2->getDate()->getHour()."<br />";
                echo $day1->getDate()->getHour()."<br />";
                echo $dateDiff."<br />";
//                }
//                else{
                    echo $day2->getDay() ."-" . $day1->getDay();
                    
//                }
                $days = (($dateDiff / 24) / 24); //3600
                return $days;
            }
        }
    }

}

