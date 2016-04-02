<?php

// define("DEBUG", true);	// For debugging purposes

/**
 * @author Daniel Andrus
 * 
 * PHP abstract class for database models.
 */
abstract class Model extends ArrayObject
{
	protected $table_name;
	
	function __construct($table_name)
	{
		assert(is_string($table_name));
		
		$this->table_name = $table_name;
	}
	
	
}
?>
