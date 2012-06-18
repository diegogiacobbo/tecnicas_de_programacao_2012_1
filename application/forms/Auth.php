<?php

class Application_Form_Auth extends Zend_Form {

    public function init() {
        $this->setMethod('post');
        $this->setAction('/index/pagamento')
         ->setMethod('post');

        // Add an email element
        $this->addElement('text', 'ticket', array(
            'label' => 'Número do ticket',
            'required' => true,
            'filters' => array('StringTrim')            
        ));

        // Add the comment element
        // Add the submit button
        $this->addElement('submit', 'submit', array(
            'ignore' => true,
            'label' => 'Pagar estacionamento'
        ));
        
      

        // And finally add some CSRF protection
        $this->addElement('hash', 'csrf', array(
            'ignore' => true,
        ));
    }

}

