<?php


if ( isset( $_GET['open'] ) )
{
   header("Location:    /trainer/charts/" . $_GET['open'] );

}

?>
<html>
<head>
	<script type="text/javascript" src="/trainer/js/swfobject.js"></script>
</head>
<body>
<?php

if ( isset( $_GET['entry'] ) )
{
?>
<script type="text/javascript">
                 swfobject.embedSWF("/trainer/swf/open-flash-chart.swf", "my_chart", "680", "500", "9.0.0", "/trainer/swf/expressInstall.swf", {"data-file":"http://<?php echo $_SERVER['HTTP_HOST']; ?>/trainer/charts/<?php echo $_GET['entry']; ?>"} );
                 </script>
                 <!--//
                 You MUST urlencode any parameter you pass into swfobject, this includes the URL!
                 In the example above there are no evil characters, but if your URL has a ? or & in it - urlencode it before passing it in.

                 Note:
                     * That the URL does not have an 'ofc=' variable in it.
                     * This way of passing the URL to the data file is useful if you have more than one chart on a page.
                 //-->


<div id="my_chart"></div>
<br /><br />
<?php
}

$dir = dir($_SERVER['DOCUMENT_ROOT'] . '/trainer/app/webroot/charts/');
while(false !== ($entry = $dir->read()))
{
 echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?entry=" . $entry . "\">swf: " . $entry . "</a> - ";
 echo "<a href=\"" . $_SERVER['PHP_SELF'] . "?open=" . $entry . "\">open: " . $entry . "</a>";
 echo "<br>";

}
$dir->close();
?>
</body>
</html>