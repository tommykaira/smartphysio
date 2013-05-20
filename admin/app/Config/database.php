<?php
class DATABASE_CONFIG {

	public $local = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'Tommyka1',
		'database' => 'smartphysio',
	);
	
	public $production = array(
		'datasource' => 'Database/Mysql',
		'persistent' => false,
		'host' => 'localhost',
		'login' => 'root',
		'password' => 'Tommyka1',
		'database' => 'smartphysio',
	);
	
	public function __construct()
	{
		
	   if ($_SERVER['HTTP_HOST'] == 'smartphysio.local'){
	        $this->default = $this->local;
	    } else {
	        $this->default = $this->production;
	    }
	}
}
