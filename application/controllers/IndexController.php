<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {

        $auth = new Application_Form_Auth();
        $this->view->auth = $auth;

        $ticket = new Application_Form_GerarTicket();
        $this->view->ticket = $ticket;
    }

    public function pagamentoAction() {
        $id = $this->_getParam("ticket");
        if (isset($id)) {
            if (self::verificaTicket($id) == true) {
                echo "<br />validado!<br /><br />";
                echo "</br>Total a pagar: R$" . self::total($id) . "</br>";
            }else
                echo "Código de barras errado!";
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
        $ticket_dao = new Application_Model_TicketDAO();
        $ticket = $ticket_dao->Lista("Select * FROM ticket WHERE id='$id'")->fetchAll(PDO::FETCH_CLASS, "Application_Model_Ticket");
        $ticket = reset($ticket);
        if ($ticket)
            if ($id == $ticket->getId())
                return true;
            else
                return false;
    }

    public static function total($id) {
        $ticket_dao = new Application_Model_TicketDAO();
        $ticket = new Application_Model_Ticket();
        $ticket = $ticket_dao->Lista("SELECT * FROM ticket WHERE id = '$id'")->fetchAll(PDO::FETCH_CLASS, "Application_Model_Ticket");
        $ticket = reset($ticket);

        if ($id == $ticket->getId()) {

            $dt_entrada = new Zend_Date($ticket->getDataEntrada(), 'YYYY-mm-dd HH:mm:ss');
            $dt_saida = new Zend_Date($ticket->getDataSaida(), 'YYYY-mm-dd HH:mm:ss');

            echo $ticket->getDataEntrada() . " - ";
            echo $ticket->getDataSaida() . "<br />";

            $valor_total = null;

            /**
             *  SE numero de dias maior
             */if (substr($dt_saida->getDay(), 0, -17) > substr($dt_entrada->getDay(), 0, 2)) {
                (int) $date_diff = (int) substr($dt_saida->getDay(), 0, -17) - (int) substr($dt_entrada->getDay(), 0, 2);
                echo "Diferença de <b>dias</b>: " . $date_diff;
                echo "(R$ " . $date_diff * 50 . ")";
                $valor_total = $date_diff * 50;
            }/**
             *   SE mesmo dia
             */ else {
                $date_diff = self::diffData($dt_entrada, $dt_saida);
                if ((0.33) < $date_diff && $date_diff <= 3) {
                    echo "Diferença de <b>horas</b>: " . $date_diff . " <br />";
                    $valor_total = 3.5;
                } else if ($date_diff <= (0.33)) {
                    echo "Diferença de <b>horas</b>: " . $date_diff . " <br />";
                    echo $date_diff;
                    $valor_total = 0.0;
                } else if ($date_diff > 3) {
                    echo "Diferença de <b>horas</b>: " . $date_diff . " <br />";
                    $valor_total = 10.0;
                }
                return (float) $valor_total;
            }
        }
    }

    public static function diffData($dt_entrada, $dt_saida) {
        (float) $hr_saida = floatval(substr($dt_saida->getHour(), -8, -6));
        (float) $hr_entrada = floatval(substr($dt_entrada->getHour(), -8, -6));
        (float) $min_saida = floatval(substr($dt_saida->getMinute(), -5, -3));
        (float) $min_entrada = floatval(substr($dt_entrada->getMinute(), -5, -3));

        return floatval($hr_saida - $hr_entrada) + floatval($min_saida - $min_entrada);
    }

    public function ticketAction() {
        
    }

    public static function geracaoCodigoTicket() {
        return rand(5, 15);
    }

    public function create($value, $options = array(), $barcodetype = 'code39', $type = 'image') {
// Somente o texto é obrigatório para a criação
        $barcodeOptions = array('text' => $value);
// Junta a configuração padrão e o $options informado, que são os valores de configuração padrão do Zend_Barcode
        $barcodeOptions = array_merge($barcodeOptions, $options);

// Não obrigatório, para retornar em JPG usa-se: 'imageType' => 'jpg'
        $rendererOptions = array();

// Para criar uma imagem, faltando só colocar os headers, o padrão de imagem é PNG
        return Zend_Barcode::render($barcodetype, $type, $barcodeOptions, $rendererOptions);
    }

}