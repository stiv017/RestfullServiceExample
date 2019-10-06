<?php

require_once '../lib/DAL/DALRezultatUpita.php';
require_once '../lib/utility/dbSettings.php';

/**
 * Class DAL
 * @author Predrag Pecev
 */

class DAL  
{
   	protected $_konekcija;
	protected $_naredba;
	protected $_podesavanjaBaze;
   
	public function __construct()
	{
		$this->_podesavanjaBaze = new dbSettings('../configurations.xml');
	}
  
	protected function UspostaviKonekcijuSaBazom() 
	{
		try
		{
			$this->_konekcija = new PDO("mysql:host=".$this->_podesavanjaBaze->get_dbserver().";dbname=".$this->_podesavanjaBaze->get_database(),
									$this->_podesavanjaBaze->get_dbuser(), 
									$this->_podesavanjaBaze->get_dbpassword(), 
									array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
			$this->_konekcija->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}
		catch (Exception $e)
		{
			die ("Neuspesna konekcija ka serveru baze podataka...");
		}
	
		return $this->_konekcija;
	}
  
	protected function PrekiniKonekcijuSaBazom()
	{
		$this->_naredba = null;
		$this->_konekcija = null;
	}

	protected function IzvrsiUpit($sqlUpit, $params)
	{
 		$this->UspostaviKonekcijuSaBazom();
 
		$this->_naredba = $this->_konekcija->prepare($sqlUpit);
		if (count($params)>0)
		{
			$keys = array_keys($params);	
			foreach($params as $key => $value)
				$this->_naredba->bindValue($key, $value);
		}

		$rezultatUpita = $this->_naredba->execute();
		
		// insert, update, delete vracaju true ili false
		// select vraca skup podataka
 
		if ($rezultatUpita)
		{
			if (strpos($sqlUpit,'SELECT') === false) return true;
		}
		else
		{
			if (strpos($sqlUpit,'SELECT') === false) return false;
				else return null; 
		}
 
		$rezultati = array();
	 
		while ($red = $this->_naredba->fetch())
		{
			$rezultatUpitaDAL = new DALRezultatUpita();
			foreach ($red as $kljuc=>$vrednost)
				$rezultatUpitaDAL->$kljuc = $vrednost;
	
			$rezultati[] = $rezultatUpitaDAL; // dodavanje objekta na kraj niza
		}
		
		$this->PrekiniKonekcijuSaBazom();
		
		return $rezultati;       
	} 
   
}

?>



