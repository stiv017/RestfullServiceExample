<?php

require_once 'Izdavac.php';

/**
 * Class Knjiga
 * @author Predrag Pecev
 */

class Knjiga implements JsonSerializable, IFieldValidator {

    protected $_idKnjiga;
    protected $_autor;
    protected $_nazivKnjiga;
	protected $_jezik;
    protected $_izdavac;

    function __construct() 
	{
		$this->_idKnjiga = 0;
		$this->_autor = "";
		$this->_nazivKnjiga = "";
		$this->_jezik = "";
		$this->_izdavac = new Izdavac();	
    }
    
    function get_idKnjiga() {
        return $this->_idKnjiga;
    }

    function get_autor() {
        return $this->_autor;
    }

    function get_nazivKnjiga() {
        return $this->_nazivKnjiga;
    }
	
	function get_jezik() {
		return $this->_jezik;
	}

    function get_izdavac() {
        return $this->_izdavac;
    }

    function set_idKnjiga($_idKnjiga) {
        $this->_idKnjiga = $_idKnjiga;
    }

    function set_autor($_autor) {
        $this->_autor = $_autor;
    }

    function set_nazivKnjiga($_nazivKnjiga) {
        $this->_nazivKnjiga = $_nazivKnjiga;
    }

    function set_izdavac($_izdavac) {
        $this->_izdavac = $_izdavac;
    }
	
	function set_jezik($_jezik)
	{
		$this->_jezik = $_jezik;
	}

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }

    public function jsonDeserialize($data)
    {
        $this->_idKnjiga = $data->{'_idKnjiga'};
        $this->_autor= $data->{'_autor'};
        $this->_nazivKnjiga = $data->{'_nazivKnjiga'};
		$this->_jezik = $data->{'_jezik'};
        $izdavac = new Izdavac();
        $izdavac->jsonDeserialize($data->{'_izdavac'});
        $this->_izdavac = $izdavac;
    }
    
    public function ValidateFields()
    {
        $this->_idKnjiga = formatInput($this->_idKnjiga);
        $this->_autor= formatInput($this->_autor);
        $this->_nazivKnjiga = formatInput($this->_nazivKnjiga);
		$this->_jezik = formatInput($this->_jezik);
        if ($this->_izdavac!=null) $this->_izdavac->ValidateFields();   
    }  
}

?>