<?php


@require_once ('negocio/TicketManager.php');
//error_reporting(NULL);

class IndexController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {

        $auth = new Application_Form_Auth();
        $this->view->auth = $auth;

        $ticket = new Application_Form_GerarTicket();
        $this->view->ticket = $ticket;

        $cod = $this->getRequest()->getParam("val");
        if (isset($cod)) {
            TicketManager::validarTicketCancela($cod);
        }
    }

    public function pagamentoAction() {
        $codigo = $this->_getParam("ticket");
        if (isset($codigo)) {
            if (TicketManager::verificaTicket($codigo) == true) {

                $total = TicketManager::total($codigo);
                if ($total != null) {
                    $this->view->total = "</br>Total a pagar: R$" . TicketManager::total($codigo) . "</br>";
                    $this->view->botao = $this->url(array(
                        'controller' => 'index',
                        'action' => 'index',
                        'val' => $this->codigo,
                            ));
                }
                else{
                    $this->view->total = "Você não precisa pagar!";
                    $this->view->botao = null;
                }
            }else
                echo "Código do ticket errado!";
            $this->view->codigo = $codigo;
        }
    }

    public function aboutAction() {
        
    }

    public function sitemapAction() {
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);

        echo $this->view->navigation()->sitemap();
    }

    public function ticketAction() {
        $var = TicketManager::geracaoCodigoTicket();
        $this->view->ticket = $var;
    }
}