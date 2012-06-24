<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {

    protected function _initCurrency() {
//        $this->locale = $this->getResource('layout');
//        $this->locale = Zend_Registry::set('locale', "pt_BR");
//        
//        $this->locale->getDefault(Zend_Locale::, TRUE);
//        $currency = new Zend_Currency($this->locale);
//        return $currency;
    }

    protected function _initViewHelper() {
        $this->bootstrap("layout");

        $layout = $this->getResource("layout");

        $view = $layout->getView();
        $view->doctype("XHTML1_STRICT");

        $view->headMeta()->appendHttpEquiv('Content-type', 'text/html');

        Zend_Session::start();
        Zend_Session::rememberMe(864000);
    }

    public function _initRouter() {
        $frontController = Zend_Controller_Front::getInstance();
        $config = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini');
        $router = $frontController->getRouter();
        $router->addConfig($config, 'routes');
    }

    protected function _initHelpers() {
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('viewRenderer');
        $viewRenderer->initView();

        $viewRenderer->view->addHelperPath("Zend/View/Helper/", "Zend_View_Helper");
    }

    protected function _initNavigation() {
        $this->bootstrap("layout");

        $layout = $this->getResource("layout");

        $view = $layout->getView();

        $config = new Zend_Config_Xml(APPLICATION_PATH . "/configs/navigation.xml", "nav");

        $navigation = new Zend_Navigation($config);
        $view->navigation($navigation);
    }

}

