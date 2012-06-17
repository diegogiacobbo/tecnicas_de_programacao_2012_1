<?php

class IndexController extends Zend_Controller_Action {

    public function init() {
        
        
        $uri =  $this->_request->getPathInfo();
//        die($uri);
        $activeNav = $this->view->navigation()->findByUri($uri);
        $activeNav->active = true;
        
        $funcionario = new Application_Model_Funcionario();
        $this->view->entries = $funcionario->fetchAll();

        
        

//        $layout = new Zend_Layout();
//
//        // Set a layout script path:
//        $layout->setLayoutPath('/path/to/layouts');
//
//        // set some variables:
//        $layout->content = $content;
//        $layout->nav = $nav;
//
//        // choose a different layout script:
//        $layout->setLayout('foo');
//
//        // render final layout
//        echo $layout->render();
    
        
    }

    public function indexAction() {
        // action body
    }
    
    public function aboutAction(){
        
    }
    
    public function sitemapAction(){
        
        $this->view->layout()->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
        
        echo $this->view->navigation()->sitemap();
    }
    

}

