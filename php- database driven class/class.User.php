<?php

class User {

	// create instance variables for table name and primary key column name to use in SQL queries later
	private $t_sTableName		= 'users';
	private $t_iPrimaryKey		= 'id';

	//create an array of all the columns in the users table, given a blank string '' value for text / varchars / date and 0 for integers
	private $t_aTableRow = array( 'first_name' => '',
							   'last_name'  => '',
							   'age'		=> 0,
							   'username'   => '',
							   'password'   => '' );

	function __construct( $rowID ) 
	{
		if ( $rowID != 0 )
		{
			$this->load( $rowID );
		}
	}

	function load( $rowID )
	{
		global $g_oDatabase;
		
		//create array with values from SELECT - see row 25 of class.Database
		$t_aSelectRow = $g_oDatabase->selectDatabase(array('*'),$this->t_sTableName,$this->t_iPrimaryKey . "= '" . $rowID ."'",true);
		if ( sizeof( $t_aSelectRow ) )
		{
			$this->id = $rowID;
			//now merge returned value into class instance array
			$this->t_aTableRow = array_merge( $this->t_aTableRow, $t_aSelectRow );
		}

	}

	function save() 
	{
		global $g_oDatabase;
		
		if ( $this->id !=  0) //id exists so UPDATE table row - see row 95 in class.Database
			$g_oDatabase->updateDatabase( $this->t_aTableRow, $this->t_sTableName, $this->t_iPrimaryKey . "= '" .$this->m_iID . "'" );
		else //id does not exists so INSERT new row into table - see row 122 in class.Database
			$this->m_iID = $g_oDatabase->insertDatabase( $this->t_aTableRow, $this->t_sTableName );

	}

	//using PHP magic methods, you can now set / get any column value in the row
	function __get( $column )
	{
		if ( isset( $this->t_aTableRow[$column] ))
			return $this->t_aTableRow[$column];
	}
		
	function __set( $column,$value )
	{
		$this->t_aTableRow[$column] = $value;
	}

}



?>