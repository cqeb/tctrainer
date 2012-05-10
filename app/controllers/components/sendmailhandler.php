<?php

class SendmailhandlerComponent extends Object 
{

	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Recaptcha', 'Unitcalc', 'Transactionhandler', 'Provider', 'Xmlhandler');
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Flowplayer', 'Unitcalc');

}

?>