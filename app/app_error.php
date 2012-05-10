<?php 

  class AppError extends ErrorHandler 
  {

    function error404($params) {
      $this->controller->redirect(array('controller'=>'starts', 'action'=>'error404'));
      parent::error404($params);
    }
	
	function missing_action($params) {
      $this->controller->redirect(array('controller'=>'starts', 'action'=>'error404'));
      parent::missing_action($params);
	}

  }

?>