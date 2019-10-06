<?php

require_once '../lib/DAL/DAL.php';
require_once '../lib/DAL/ICommonDatabaseMethods.php';
require_once '../lib/class/Izdavac.php';

/**
 * Class IzdavacDAL
 * @author Predrag Pecev
 */

class IzdavacDAL extends DAL implements ICommonDatabaseMethods
{
	function __construct() 
	{
		parent::__construct();
	}
	      
	public function GetAll() 
    {
		try
		{
			$sqlQuery = "SELECT * FROM IZDAVAC";
			$params = array();
			
			$results = $this->IzvrsiUpit($sqlQuery, $params);
			$izdavacResults = array();
			
			foreach ($results as $k)
			{
				$izdavac = new Izdavac();
                //$k->idIzdavac – idIzdavac je naziv kolone iz tabele Izdavac
				$izdavac->set_idIzdavac($k->idIzdavac);
                //$k->nazivizdavac – nazivizdavac je naziv kolone iz tabele Izdavac
				$izdavac->set_nazivIzdavac($k->nazivIzdavac);
                //$k->Pec – pib je naziv kolone iz tabele Izdavac
				$izdavac->set_pib($k->pib);
				$izdavacResults[] = $izdavac;

			}
			
			return $izdavacResults;
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}   
    }

    public function GetOne($object) 
	{
		try
		{
			$izdavacResult = new Izdavac();
			$izdavacResult->set_idIzdavac($object);
			$izdavacResult->ValidateFields();
			
			$sqlQuery = "SELECT * FROM IZDAVAC WHERE idIzdavac = :idIzdavac";
			$params = array(":idIzdavac"=>$izdavacResult->get_idIzdavac());	   
			
			$results = $this->IzvrsiUpit($sqlQuery, $params);
			
			if (count($results)>0)
			{
				$k = $results[0];
				$izdavacResult->set_idIzdavac($k->idIzdavac);
				$izdavacResult->set_nazivIzdavac($k->nazivIzdavac);
				$izdavacResult->set_pib($k->pib);
			}
			
			return $izdavacResult;
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}
    }
	
	// --------------------------------------------------------------------------------------------------- //
	// PROVERITI DA LI SU KOREKTNO REALIZOVANE METODE AddOne, EditOne, DeleteOne, RecordExists, Duplicate  //
	// --------------------------------------------------------------------------------------------------- //
	
	public function AddOne($object) 
	{
		try
		{
			$object->ValidateFields();
		
			$sqlQuery = "INSERT INTO SMER (nazivIzdavac, pib) VALUES (:nazivIzdavac, :pib)";
			$params = array(":nazivIzdavac"=>$object->get_nazivIzdavac(),":pib"=>$object->get_sifra());	
			return $this->IzvrsiUpit($sqlQuery, $params); 
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}
    }

    public function EditOne($object) 
    {
		try
		{
			$object->ValidateFields();
			$sqlQuery = "UPDATE SMER SET nazivIzdavac = :nazivIzdavac, pib = :pib WHERE idIzdavac = :idIzdavac";
			$params = array(":nazivIzdavac"=>$object->get_nazivIzdavac(), ":pib"=>$object->get_sifra(), ":idIzdavac"=>$object->get_idIzdavac());

			return $this->IzvrsiUpit($sqlQuery, $params);
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}
    }

    public function DeleteOne($object) 
    {
		try
		{
		    $object->ValidateFields();
		
			$sqlQuery = "DELETE FROM SMER WHERE idIzdavac = :idIzdavac";
			$params = array(":idIzdavac"=>$object->get_idIzdavac());
		
			return $this->IzvrsiUpit($sqlQuery, $params);
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}
    }
	
	public function RecordExists($object)
	{
		try
		{
			$sqlQuery="SELECT * FROM Izdavac WHERE idIzdavac = :idIzdavac";
			$params = array(":idIzdavac" =>(int)$object);
		
			$results = $this->IzvrsiUpit($sqlQuery,$params);  
			if (count($results)>0) return true;
			return false;
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}
	}
	
	public function Duplicate($object)
	{
		try
		{
			$object->ValidateFields();
			$sqlQuery="SELECT * FROM Izdavac WHERE nazivIzdavac = :nazivizdavac AND pib = :pib";
			$params = array(":nazivizdavac"=>$object->get_nazivIzdavac(),":pib"=>$object->get_sifra());	
		
			$results = $this->IzvrsiUpit($sqlQuery,$params);  
			if (count($results)>0) return true;
				else return false;
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}

	}
}

?>

