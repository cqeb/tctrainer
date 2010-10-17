<?php

class OfcHelper extends AppHelper {

	var $helpers = array('Html', 'Javascript');

	function beforeRender()
  {
           $view = ClassRegistry::getObject('view');
           if (is_object($view)) 
           {
              $view->addScript($this->Javascript->link('swfobject'));
           }
  }

  function createflash( $div = 'my_chart', $width = '680', $height = '500', $url = '' )
  {

           $output = '
           <script type="text/javascript">
           swfobject.embedSWF("' . Configure::read('App.serverUrl') . '/swf/open-flash-chart.swf", "' . $div . '", "' . $width .
              '", "' . $height . '", "9.0.0", "' . Configure::read('App.serverUrl') . '/swf/expressInstall.swf", {"data-file":"' .
              $url . '"} );
           </script>
           <!--//
           You MUST urlencode any parameter you pass into swfobject, this includes the URL!
           In the example above there are no evil characters, but if your URL has a ? or & in it - urlencode it before passing it in.

           Note:
               * That the URL does not have an \'ofc=\' variable in it.
               * This way of passing the URL to the data file is useful if you have more than one chart on a page.
           //-->
           ';

           return $output;
  }
}

?>