<?php

//Joomla or die!
defined('_JEXEC') or die();

class VombieConverterControllerCpanel extends JConverterController
{
	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
	}

    function display() {
        JRequest::setVar( 'view', 'cpanel' );
        parent::display();
    }
}
?>
