<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Garmin Import</title>
</head>
<style type="text/css" media="all">@import "./device/style/communicator2.css";</style>
<script type="text/javascript" src="./device/prototype.js">&#160;</script>
<script type="text/javascript" src="./device/GarminDeviceDisplay.js">&#160;</script>
<script type="text/javascript">	
	function load() {
	    var display = new Garmin.DeviceDisplay("garminDisplay", { 
			pathKeyPairsArray: ["http://www.tricoretraining.com","0d20a68aa7d4309c3294cc3d70d015d0"],
			showReadDataElement: true,
			showProgressBar: true,
			showFindDevicesElement: true,
			showFindDevicesButton: false,
			showDeviceButtonsOnLoad: false,
			showDeviceButtonsOnFound: false,
			autoFindDevices: true,
			showDeviceSelectOnLoad: false,
			autoHideUnusedElements: true,
			showReadDataTypesSelect: false,
			readDataType: Garmin.DeviceControl.FILE_TYPES.tcxDir,
			deviceSelectLabel: "Choose Device <br/>",
			readDataButtonText:			"List Activities",
			showCancelReadDataButton:		false,
			lookingForDevices: 'Searching for Device <br/><br/> <img src="/trainer/garmin/device/style/ajax-loader.gif"/>',
			uploadsFinished: "Transfer Complete",
			uploadSelectedActivities: true,
			uploadCompressedData: false,    // Turn on data compression by setting to true.
			uploadMaximum: 10, 
			dataFound: "#{tracks} activities found on device",
			showReadDataElementOnDeviceFound: true,
			postActivityHandler: function(activityXml, display) {
				var timedate = new Date();
				var timems = timedate.getMilliseconds();
				new Ajax.Request('/trainer/trainingstatistics/garmin_import?timems='+timems, {
  					method: 'post',
  					parameters: {activities: activityXml},
					onComplete: function(response) {
						alert('Garmin workout imported.');
					}
  				});
//                $('activity').innerHTML += '<hr/><pre>Workout imported.</pre>';
				$('activity').innerHTML += '<hr/><pre>'+activityXml.escapeHTML()+'</pre>';
				//pausecomp(1000);
			}
		});
	}

function pausecomp(millis) 
{
	var date = new Date();
	var curDate = null;

	do { curDate = new Date(); } 
	while(curDate-date < millis);
} 

</script>

<body onload="load()">

	<h2>Upload Selected Fitness Activities</h2>
	if you have problems, try <a target="_blank" href="http://connect.garmin.com/transfer/upload">this page</a> first.<br /><br />

    <a href="javascript:window.close();">CLOSE WINDOW</a> after finishing your GARMIN imports.
    <br /><br />

	<table border="0" cellpadding="4" cellspacing="0" width="100%">
		<tr>
			<td>
				<div id="garminDisplay"></div>
			</td>
		</tr>
        <tr>
			<td>
				<div id="activity"></div>
			</td>
		</tr>
	</table>

</body>
</html>
