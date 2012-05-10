<?php

echo "<html><body>";
echo "thanks for posting<br>\n";

$mainpath = $_SERVER['DOCUMENT_ROOT'] . '/trainer/app/webroot/garmin/';
    
include( $mainpath . 'xml2array.php' );

$filename = $mainpath . 'cache/course.' . md5( serialize( $_POST ) ) . '.txt';

$logfile  = $mainpath . 'cache/garminlog.txt';

$logcontent = '----------------------------------------------------------------<br>\n';

if ( isset( $_GET['debug'] ) && $_GET['debug'] == 'true' ) $_POST['activities'] = '<Activities></Activities>';

if ( isset( $_POST ) ) {

	if ( isset( $_POST['activities'] ) ) {
		$somecontent = serialize(xml2array( $_POST['activities'] ) );
		
		$logcontent .= "object in POST ok " . md5( serialize( $_POST ) ) . " ## <br>\n";
	} else {
		//$somecontent = serialize($_POST);
		$somecontent = "";
		$logcontent .= "object not in POST ## <br>\n";
	}
}

if ( $somecontent != '' ) {

    // In our example we're opening $filename in append mode.
    // The file pointer is at the bottom of the file hence
    // that's where $somecontent will go when we fwrite() it.
    if (!$handle = fopen($filename, 'w')) {
         $logcontent .= "Cannot open file ($filename) ## <br>\n";
         exit;
    }

    // Write $somecontent to our opened file.
    if (fwrite($handle, $somecontent) === FALSE) {
        $logcontent .= "Can not write to file ($filename) ## <br>\r\n";
        exit;
    }

    $logcontent .= "Success, wrote content to file ($filename) ## <br>\r\n";

    fclose($handle);

}

if (!$loghandle = fopen($logfile, 'a')) {
    	echo "Cannot open logcontent ## <br>\r\n";
	exit;
}

if (fwrite($loghandle, $logcontent) === FALSE) {
    	echo "Cannot write to logcontent ## <br>\r\n";
	exit;
}

fclose($loghandle);

echo $logcontent;

echo "</body></html>";

?>
