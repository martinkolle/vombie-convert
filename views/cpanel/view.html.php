<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport( 'joomla.application.component.view' );

class JConverterViewCpanel extends JView
{
	function display($tpl = null)
	{
		JToolBarHelper::title(   JText::_( 'JConverter' ), 'generic.png' );
		JToolBarHelper::preferences('com_jconverter');
		parent::display($tpl);
	}
}
