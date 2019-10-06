<?php

require_once 'IFieldValidator.php';
require_once 'inputFormaterCustom.php'; 

/**
 * Class Izdavac
 * @author Predrag Pecev
 */

class Izdavac implements JsonSerializable, IFieldValidator
{
	protected $_idIzdavac;
	protected $_nazivIzdavac;
	protected $_pib;
	
	public function __construct() 
	{
        $this->_idIzdavac = 0;
		$this->_nazivIzdavac = "";
		$this->_pib = "";	
	}
    
	function get_idIzdavac() {
        return $this->_idIzdavac;
    }

    function get_nazivIzdavac() {
        return $this->_nazivIzdavac;
    }
	
	function get_pib() {
        return $this->_pib;
    }

    function set_idIzdavac($_idIzdavac) {
        $this->_idIzdavac = $_idIzdavac;
    }

    function set_nazivIzdavac($_nazivIzdavac) {
        $this->_nazivIzdavac = $_nazivIzdavac;
    }
	
	function set_pib($_pib) {
        $this->_pib = $_pib;
    }

    public function jsonSerialize() {
        return (object) get_object_vars($this);
    }
    
    public function jsonDeserialize($data)
    {
        $this->_idIzdavac = $data->{'_idIzdavac'};
        $this->_nazivIzdavac = $data->{'_nazivIzdavac'};
		$this->_pib = $data->{'_pib'};
    }
	
    public function ValidateFields()
    {
		$this->_idIzdavac = formatInput($this->_idIzdavac);
        $this->_nazivIzdavac = formatInput($this->_nazivIzdavac);
		$this->_pib = formatInput($this->_pib);  
    }
}

?>
