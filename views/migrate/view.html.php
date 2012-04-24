<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class JConverterViewMigrate extends JView
{
	/**
	 *
	 * @return void
	 **/
	function display($tpl = null)
	{
		JToolBarHelper::title(  JText::_( 'Migrate!' ), 'install.png' );

		$status = & $this->get('Migration');

		print_r($status);

		$errors = $this->__errorCheck($status);

		$this->assignRef('errors', $errors);
		JToolBarHelper::preferences('com_jconverter');


		parent::display($tpl);
	}

	function __errorCheck ( $status ) {

		//print_r($status);

		$errors = array();

		foreach ($status as $key => $value) {

			if ($value == 1062) {
				$errors[$key] = "FAILED! - Duplicate key";
            }else if ($value == 1054) {
                $errors[$key] = "FAILED! - Unknown columm";
			}else if ($value == 0) {
				$errors[$key] = "OK!";
			}else if ($value == 9999) {
				$errors[$key] = "Disable";
			}
		}

		return $errors;
	}

}
