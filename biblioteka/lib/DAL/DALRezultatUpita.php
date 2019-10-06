<?php

/**
 * Class DALRezultatUpita
 * @author Predrag Pecev
 */

class DALRezultatUpita 
{
	public $_rezultati = array();
	
	public function __construct() {}
	
	public function __set($kljuc,$vrednost){
		$this->_rezultati[$kljuc] = $vrednost;
	}
	
	public function __get($kljuc){ 
		if (isset($this->_rezultati[$kljuc])) return $this->_rezultati[$kljuc];
			else return null;
	}
}

?>