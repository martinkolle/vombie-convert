<?php

//Joomla or die!
defined('_JEXEC') or die();

class VombieConverterControllerMigrate extends JConverterController
{

	/**
	 * constructor (registers additional tasks to methods)
	 * @return void
	 */
	function __construct()
	{
		parent::__construct();
		parent::registerDefaultTask('migrate');
	}

    function migrate(){

		$model =& $this->getModel('migrate');
		JRequest::setVar( 'view', 'migrate' );
		parent::display();
    }




    function display() {

        JRequest::setVar( 'view', 'migrate' );
        parent::display();
    }
}
?>
