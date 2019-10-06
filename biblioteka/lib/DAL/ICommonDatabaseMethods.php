<?php

/**
 * Interface for DAL Objects
 * @author Predrag Pecev
 */
 
interface ICommonDatabaseMethods 
{
    public function AddOne($object);
    public function EditOne($object);
    public function DeleteOne($object);
    public function GetOne($object);
    public function GetAll();
	public function RecordExists($object);
	public function Duplicate($object);
}

?>
