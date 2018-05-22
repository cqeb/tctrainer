<?php

class FlowplayerHelper extends AppHelper {
	  
	var $helpers = array('Html', 'Javascript');

	function beforeRender()
  {
           $view = ClassRegistry::getObject('view');
           if (is_object($view)) 
           {
              $view->addScript($this->Javascript->link('flowplayer-3.1.4.min'));
           }
  }

  function showvideo( $swffile = '', $swfwidth = '450', $swfheight = '330' )
  {

           if ( $swffile != '' )
           {
                 $output = '
                  <a href="' . Configure::read('App.serverUrl') . '/flowplayer/videos/' . $swffile . '" style="display:block;width:' . $swfwidth . 'px;height:' . $swfheight . 'px" id="player"></a>
                  <script>
                                    flowplayer("player", "' . Configure::read('App.serverUrl') . '/flowplayer/flowplayer-3.1.5.swf");
                  </script>
                 ';

           }
           return $output;

   }
}
?>