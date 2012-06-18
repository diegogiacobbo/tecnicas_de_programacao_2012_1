<?php

class IndexController extends Zend_Controller_Action {

	public function init() {


		$uri = $this->_request->getPathInfo();
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

		$router = new Zend_View_Helper_Url();

//		echo $router->url(array(
//			'controller' => 'Admin',
//			'action' => 'index',
//			'id' => 25
//		));
		$ticket_pay_url = $router->url(array(
			'controller' => 'index',
			'action' => 'pagamento'
				));

		$link = "<a href=" . $ticket_pay_url . ">" . Pagar . "</a>";

		echo $link;
	}

	public function pagamentoAction() {

		$router = new Zend_View_Helper_Url();

		$ticket_allow = $router->url(array(
			'controller' => 'index',
			'action' => 'index'
				));

		$link = "<a href=" . $ticket_allow . ">" . Liberar . "</a>";

		echo $link;
	}

	public function aboutAction() {

		echo "ABOUT!";
	}

	public function sitemapAction() {

		$this->view->layout()->disableLayout();
		$this->_helper->viewRenderer->setNoRender(true);

		echo $this->view->navigation()->sitemap();
	}

}

