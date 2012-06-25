<?php

class Application_Form_Auth extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        $this->setAction('/index/pagamento')
         ->setMethod('post');

        $this->addElement('text', 'ticket', array(
            'label' => 'Número do ticket',
            'required' => true,
            'filters' => array('StringTrim')            
        ));

        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => ''
        ));
    }

}

