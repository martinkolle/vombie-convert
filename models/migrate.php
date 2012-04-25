<?php

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die();

jimport('joomla.application.component.model');

class VombieConverterModelMigrate extends JModel
{
	var $_config = null;
	var $_externalDB = null;
	var $_status = array();

	/**
	 * Constructor that retrieves the ID from the request
	 *
	 * @access	public
	 * @return	void
	 */
	function __construct() {
		parent::__construct();

		ini_set('max_execution_time','3600');

		$this->_config = $this->getConfig();
		$this->getConnectToExternalDB();

	}


	function getConfig() {

/*		
		$configFile = JPATH_COMPONENT.DS.'jconverter_config.php';
		include( $configFile );
*/

		$params = JComponentHelper::getParams('com_jconverter');

		$config = array();
        $config['driver']   = 'mysqli';// $params->get('driver_wordpress'); NO SUPPORT FOR OTHE DATABASES
		$config['host']     = $params->get('host_wordpress');
        $config['user']     = $params->get('username_wordpress');
        $config['password'] = $params->get('password_wordpress');
        $config['database'] = $params->get('databasename_wordpress');
        $config['prefix']   = $params->get('prefix_wordpress');

		return $config;
	}


	function getConnectToExternalDB () {

		$this->_externalDB = JDatabase::getInstance( $this->_config );

	/*	if ( $this->_externalDB->getMessage ) {
			//print_r($this->_externalDB);
			$this->setError($this->_externalDB->getMessage);
			return false;
		}
		*/

		$query = "SET NAMES `utf8`";
        $this->_externalDB->setQuery( $query );
        $data = $this->_externalDB->query();

		return true;

	}

	function getMigration () {

		$params = JComponentHelper::getParams('com_jconverter');

		if ( !$this->getError() ) {
			if ($params->get('users_wordpress') == '1')
				$this->_status['users'] = $this->migrateWpUsers();
			else
				$this->_status['users'] = 9999;

			return $this->_status;

		}

	}

    function migrateWpUsers() {
/*
		$query = "SELECT u.*, m.meta_value FROM " . $this->_config['prefix'] . "users u, "
		. $this->_config['prefix'] . "usermeta m "
		." WHERE u.id = m.user_id AND m.meta_key = 'wp_capabilities' AND u.user_login != 'admin'";
*/
		$query = "SELECT u.* FROM ".$this->_config['prefix']. "users u WHERE u.user_login != 'admin'";

		$this->_externalDB->setQuery( $query );
		$users = $this->_externalDB->loadObjectList();
		$error = array();
		print_r($users);
		//$ret = $this->insertObjectList('#__users', $users);

		$db =& JFactory::getDBO();

		foreach ($users as $user)
		{

			$uName = mysql_real_escape_string($user->display_name);
			$uLogin = mysql_real_escape_string($user->user_login);
			$uEmail = mysql_real_escape_string($user->user_email);
			$uPass = mysql_real_escape_string($user->user_pass);
			$uRegDate = mysql_real_escape_string($user->user_registered);

			$user = array();
			$user['fullname'] = $uName;
			$user['email'] = $uEmail;
			$user['password_clear'] = $uPass;
			$user['username'] = $uLogin;

			$instance = JUser::getInstance();

			jimport('joomla.application.component.helper');
			$config_users = JComponentHelper::getParams('com_users');
			// Default to Registered.
			$defaultUserGroup = $config_users->get('new_usertype', 2);

			$acl = JFactory::getACL();

			$instance->set('id'         	, 0);
			$instance->set('name'           , $user['fullname']);
			$instance->set('username'       , $user['username']);
			$instance->set('password'		 , $user['password_clear']);
			$instance->set('email'          , $user['email']);  // Result should contain an email (check)
			$instance->set('usertype'       , 'deprecated');
			$instance->set('groups'     	, array('2','9'));

			//If autoregister is set let's register the user
    		if (!$instance->save()) {
        		$error[] = "Could not add user: ".$user['username']. "with email:".$user['email'].". ERROR: ". $instance->getError();
   			}

			$user_id = JUserHelper::getUserId($uLogin);
			$end_date = strtotime(date("Y-m-d H:i:s", strtotime($uRegDate)) . "+1 year");

			if($user_id):
				$msc_id = '1'; //$msc_id = $params->get('');
				require_once(JPATH_SITE.DS.'components'.DS.'com_osemsc'.DS.'init.php');
				$member= oseRegistry :: call('member');
				$member->instance($user_id, 'member_id');
				$member->joinMsc($msc_id);

				$query = $db->getQuery(true);
				$query->update('#__osemsc_member_view');
				$query->set("start_date = ".$db->quote($uRegDate));
				$query->set("expired_date = ".$db->quote(date("Y-m-d H:i:s",$end_date)));
				$db->setQuery($query);
				
				if(!$db->query()){
					$error[] = "Could not update member_id: ".$user_id. " with start and end date. ERROR: ". $db->getErrorMsg();
				}

				/*
				$db 	= JFactory::getDBO();
				$db->setQuery("UPDATE #__osemsc_member_view SET start_date = ".$uRegDate." WHERE member_id =".$user_id );

					if(!$db->query()){
						$error[] = "Could not update id: ".$user_id. "with start and end date. ERROR: ". $db->getErrorMsg();
					}
				*/
			endif;
		}
		if($error){
			$this->vombieErrors($error);
			$this->logWrite($error,'log');
		}

		return 0;
	}

	function wpUserType($userDetails) {

		if (strpos($userDetails, 'administrator') !== false)
			return 'Administrator';
		else
			return 'Registered';
	}

	function vombieErrors($error){
			return JError::raiseWarning('SOME_ERROR_CODE', implode('<br />',$error));
	}

	function logWrite($write, $type){
		$file 		= date("Y-m-d_H-m-s").".txt";
		$directory	= JPATH_COMPONENT_ADMINISTRATOR."/log/";
		$fileHandle = fopen($directory.$file, 'w') or die("can't open file");
		$stringData = implode("\r",$write);
		fwrite($fileHandle, $stringData);
		fclose($fileHandle);

		return $directory.$file;
	}

}
?>
