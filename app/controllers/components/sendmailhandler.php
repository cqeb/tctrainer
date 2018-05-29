<?php

class SendmailhandlerComponent extends Object 
{
	var $components = array('Email', 'Cookie', 'RequestHandler', 'Session', 'Unitcalc', 'Transactionhandler', 'Provider', 'Xmlhandler');
	var $helpers = array('Html', 'Form', 'Javascript', 'Time', 'Session', 'Unitcalc');
}

?>