<?php

/**
 * Class dbSettings
 * @author Predrag Pecev
 */

class dbSettings
{
	protected $_dbserver;
	protected $_dbuser;
	protected $_dbpassword;  
	protected $_database;
   
	public function __construct($path)
	{
		$xmlstr = file_get_contents($path);
		$configurations = new SimpleXMLElement($xmlstr);
		$this->_dbserver = $configurations->database[0]->server;
		$this->_dbuser = $configurations->database[0]->user;
		$this->_dbpassword = $configurations->database[0]->password;
		$this->_database = $configurations->database[0]->databasename;	
	}
   
	function get_dbserver() {
		return $this->_dbserver;
	}
	
	function get_dbuser() {
		return $this->_dbuser;
	}

	function get_dbpassword() {
		return $this->_dbpassword;
	}

	function get_database() {
		return $this->_database;
	}
	
	function set_dbserver($_dbserver) {
		$this->_dbserver = $_dbserver;
	}

	function set_dbuser($_dbuser) {
		$this->_dbuser = $_dbuser;
	}

	function set_dbpassword($_dbpassword) {
		$this->_dbpassword = $_dbpassword;
	}

	function set_database($_database) {
       $this->_database = $_database;
	}
}

?>


