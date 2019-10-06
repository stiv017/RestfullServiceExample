<?php

require_once '../lib/DAL/DAL.php';
require_once '../lib/DAL/IzdavacDAL.php';
require_once '../lib/class/Knjiga.php';

/**
 * Class KnjigaDAL
 * @author Predrag Pecev
 */

class KnjigaDAL extends DAL implements ICommonDatabaseMethods
{
    function __construct() 
	{
		parent::__construct();
    }
      
    public function PrikaziKnjigePretraga($search)
    {
		try
		{
		    $tempStud = new Knjiga();
			$tempStud->set_nazivKnjiga($search);
			$tempStud->ValidateFields();
		
			$sqlQuery="SELECT * FROM Knjiga WHERE nazivKnjiga LIKE :nazivKnjiga";
			$params = array(":nazivKnjiga"=>"%".$tempStud->get_nazivKnjiga()."%");
        
			$results = $this->IzvrsiUpit($sqlQuery, $params);

			$knjigaResults = array();
			
			foreach ($results as $k)
			{
				$knjigaResult = new Knjiga();
				$knjigaResult->set_idKnjiga($k->idKnjiga);
				$knjigaResult->set_nazivKnjiga($k->nazivKnjiga);
				$knjigaResult->set_autor($k->autor);
				$knjigaResult->set_jezik($k->jezik);
				$izdavacDAL = new IzdavacDAL();
				$knjigaResult->set_izdavac($izdavacDAL->GetOne($k->idIzdavac));
				$knjigaResults[] = $knjigaResult;

			}
		   
			return $knjigaResults;
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}
		
    }
    
    public function AddOne($object) 
	{
        try
		{
			$object->ValidateFields();
		
			$sqlQuery="INSERT INTO Knjiga (nazivKnjiga, autor, jezik, idIzdavac) VALUES(:nazivKnjiga, :autor, :jezik, :idIzdavac)";
			$params = array(":autor"=>$object->get_autor(),
						":nazivKnjiga" =>$object->get_nazivKnjiga(),
						":jezik"=>$object->get_jezik(),
						":idIzdavac"=>$object->get_izdavac()->get_idIzdavac());
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
			$sqlQuery="DELETE FROM Knjiga WHERE idKnjiga = :idKnjiga";
			$params = array(":idKnjiga"=>$object->get_idKnjiga());
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
			$sqlQuery="UPDATE Knjiga SET nazivKnjiga = :nazivKnjiga, autor = :autor, jezik = :jezik, idIzdavac = :idIzdavac WHERE idKnjiga = :idKnjiga";
			$params = array(":autor"=>$object->get_autor(),
						":nazivKnjiga" =>$object->get_nazivKnjiga(),
						":jezik"=>$object->get_jezik(),
						":idIzdavac"=>$object->get_izdavac()->get_idIzdavac(),
						":idKnjiga"=>$object->get_idKnjiga());
			return $results = $this->IzvrsiUpit($sqlQuery, $params);
		}
		catch (Exception $e)
		{
			return false; // ako nesto ne valja sa upitom, ne izvrsi se kako treba, vrati false
		}

    }

    public function GetAll() 
    {
		try
		{
			$sqlQuery="SELECT * FROM Knjiga";
			$params = array();
			$results = $this->IzvrsiUpit($sqlQuery,$params);
		   
			$knjigaResults = array();

			foreach ($results as $k)
			{
				$knjigaResult = new Knjiga();
				$knjigaResult->set_idKnjiga($k->idKnjiga);
				$knjigaResult->set_nazivKnjiga($k->nazivKnjiga);
				$knjigaResult->set_autor($k->autor);
				$knjigaResult->set_jezik($k->jezik);
				$izdavacDAL = new IzdavacDAL();
				$knjigaResult->set_izdavac($izdavacDAL->GetOne($k->idIzdavac));
				$knjigaResults[] = $knjigaResult;
			}
	   
			return $knjigaResults;  
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
			$knjigaResult = new Knjiga();
			$knjigaResult->set_idKnjiga($object);
        
			$sqlQuery="SELECT * FROM Knjiga WHERE idKnjiga = :idKnjiga";
			$params = array(":idKnjiga" =>$knjigaResult->get_idKnjiga());
		
			$results = $this->IzvrsiUpit($sqlQuery,$params);  
			if (count($results)>0)
			{
				$k = $results[0];
           
				$knjigaResult = new Knjiga();
				$knjigaResult->set_idKnjiga($k->idKnjiga);
				$knjigaResult->set_nazivKnjiga($k->nazivKnjiga);
				$knjigaResult->set_autor($k->autor);
				$knjigaResult->set_jezik($k->jezik);
				$izdavacDAL = new IzdavacDAL();
				$knjigaResult->set_izdavac($izdavacDAL->GetOne($k->idIzdavac));	 
			}
			return $knjigaResult;
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
			$sqlQuery="SELECT * FROM Knjiga WHERE idKnjiga = :idKnjiga";
			$params = array(":idKnjiga" =>(int)$object);
		
			$results = $this->IzvrsiUpit($sqlQuery,$params);  
			if (count($results)>0) return true;
				else return false;
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
			$sqlQuery="SELECT * FROM Knjiga WHERE autor = :autor AND nazivKnjiga = :nazivKnjiga AND jezik = :jezik AND idIzdavac = :idIzdavac";
			$params = array(":autor"=>$object->get_autor(),
						":nazivKnjiga" =>$object->get_nazivKnjiga(),
						":jezik"=>$object->get_jezik(),
						":idIzdavac"=>$object->get_izdavac()->get_idIzdavac());
		
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
