<?php

require_once 'REST.php';
require_once '../lib/DAL/IzdavacDAL.php';
require_once '../lib/DAL/KnjigaDAL.php';

/**
 * Class API
 * @author Predrag Pecev
 */
	
class API extends REST 
{
	public function __construct() 
	{
        parent::__construct();
	}
	
	protected $_urlPattern;
	protected $_paramCount;

	public function processApi() 
	{
		try
		{
			if (!isset($_REQUEST['x'])) $this->response('false', 404);
			$this->_urlPattern = explode("/",strtolower(trim($_REQUEST['x'])));
			$this->_urlPattern = array_filter($this->_urlPattern, function($value) { return $value !== ""; });
			$func = $this->_urlPattern[0];
			$this->_paramCount = count($this->_urlPattern) - 1;
			if ((int) method_exists($this, $func) > 0) 
			{
				$callMethod = false;
				switch($func)
				{
					// ------------------------------------------------------------ //
					// Poziv metode : http://localhost/biblioteka/services/knjige   //
					// ------------------------------------------------------------ //
					case "knjige":
						if ($this->_paramCount==0) $callMethod = true;
						break;
					// ----------------------------------------------------------------- //
					// Poziv metode : http://localhost/biblioteka/services/knjiga/{id}   //
					// ----------------------------------------------------------------- //
					case "knjiga":
						if ($this->_paramCount==1) $callMethod = true;
						break;
					// ----------------------------------------------------------------------------------- //
					// Poziv metode : http://localhost/biblioteka/services/knjigepretraga/{search sting}   //
					// ----------------------------------------------------------------------------------- //
					case "knjigepretraga":
						if ($this->_paramCount<=1) $callMethod = true; // moze se poslati string za pretragu a i ne mora
						break;
					// ------------------------------------------------------------------ //
					// Poziv metode : http://localhost/biblioteka/services/izmeniknjigu   //
					// ------------------------------------------------------------------ //
					case "izmeniknjigu":
						if ($this->_paramCount==0) $callMethod = true;
						break;
					// ------------------------------------------------------------------ //
					// Poziv metode : http://localhost/biblioteka/services/dodajknjigu    //
					// ------------------------------------------------------------------ //
					case "dodajknjigu":
						if ($this->_paramCount==0) $callMethod = true;
						break;
					// ----------------------------------------------------------------------- //
					// Poziv metode : http://localhost/biblioteka/services/obrisiknjigu/{id}   //
					// ----------------------------------------------------------------------- //
					case "obrisiknjigu":
						if ($this->_paramCount==1) $callMethod = true;
						break;
				}
				if ($callMethod) $this->$func();
					else $this->response('false', 404);
			}
			else $this->response('false', 404); 
		}
		catch (Exception $e)
		{
			$this->response('false', 404); 
		}
	}

    public function json($data) 
	{
        if (is_array($data)) return json_encode($data);
    }

	// metode REST servisa

	private function knjige() 
	{
		if ($this->get_request_method() != "GET")
			$this->response('false', 405);
			
		$knjigaDAL = new KnjigaDAL();
		$result = $knjigaDAL->GetAll();
		if (!is_array($result)) $this->response('false', 404); 
			else $this->response($this->json($result), 200); 
	}
            
			
    private function knjigepretraga() 
	{
        if ($this->get_request_method() != "GET")
            $this->response('false', 405);
			                
		$search = "";
		if ($this->_paramCount==1) $search =(string) $this->_urlPattern[1];
	
		$knjigaDAL = new KnjigaDAL();
		$result = $knjigaDAL->PrikaziKnjigePretraga($search);
		if (!is_array($result)) $this->response('false', 404); 
			$this->response($this->json($result), 200); 
    }
	
    private function knjiga() 
	{
		if ($this->get_request_method() != "GET") 
			$this->response('false', 405);

		$idKnjiga = (int) $this->_urlPattern[1];
		
		if ($idKnjiga > 0) 
		{
			$knjigaDAL = new KnjigaDAL();

			$foundOne = $knjigaDAL->RecordExists($idKnjiga);
			if (!$foundOne) $this->response('false', 404); 
				else
				{
					$result = $knjigaDAL->GetOne($idKnjiga);
					if (!$result) $this->response('false', 404); 
						else
						{
							$resultArray = array();
							array_push($resultArray, $result);
							$this->response($this->json($resultArray), 200); 
						}
				}
		}
		$this->response('false', 404); 
    }

	private function dodajknjigu() 
	{
		if ($this->get_request_method() != "POST") 
			$this->response('false', 405);
		
		$data = json_decode(file_get_contents('php://input'), true);
		if ($data == "") $this->response('false', 404);
			      
		$knjiga = new Knjiga();
		$knjiga->jsonDeserialize(json_decode(file_get_contents('php://input')));
		
		$knjigaDAL = new KnjigaDAL();
		if ($knjigaDAL->Duplicate($knjiga)) $this->response('false', 409);
		
		$succ = $knjigaDAL->AddOne($knjiga);
		if (!$succ) $this->response('false', 404); 
			else $this->response('true', 201); 
	}
	
	private function izmeniknjigu() 
	{
		if ($this->get_request_method() != "PUT") 
			$this->response('false', 405);
				
		$data = json_decode(file_get_contents('php://input'), true);
		if ($data == "") $this->response('false', 404);
			else $this->_request = $data;
			
		$knjigaDAL = new KnjigaDAL();
		$foundOne = $knjigaDAL->RecordExists($this->_request['_idKnjiga']);
		
		if (!$foundOne) $this->response('false', 404); 
		else
		{
			$knjiga = new Knjiga();
			$knjiga->jsonDeserialize(json_decode(file_get_contents('php://input')));
			
			if ($knjigaDAL->Duplicate($knjiga)) $this->response('false', 409);
			
			$succ = $knjigaDAL->EditOne($knjiga);
			if (!$succ) $this->response('false', 404); 
				else $this->response('true', 200); 
		}
	}
			
	private function obrisiknjigu() 
	{
		if ($this->get_request_method() != "DELETE") 
			$this->response('false', 405);
			
		$idKnjiga = (int) $this->_urlPattern[1];
		
		$knjigaDAL = new KnjigaDAL();
		$foundOne = $knjigaDAL->RecordExists($idKnjiga);
		
		if ($idKnjiga > 0) 
		{
			if (!$foundOne) $this->response('false', 404); 
			else
			{
				$knjiga = new Knjiga();
				$knjiga->set_idKnjiga($idKnjiga);

				$succ = $knjigaDAL->DeleteOne($knjiga);
				if (!$succ) $this->response('false', 404); 
					else $this->response('true', 200); 
			}
		}
		$this->response('false', 404); 
		
	}
	
}

// formiraj i pokreni API
	
$api = new API();
$api->processApi();

?>