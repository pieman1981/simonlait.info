<?php

class Database
{
	private $m_oConnection;

	function __construct($p_sHost= '', $p_sUsername = '', $p_sPassword = '', $p_sDatabase = '')
	{
		$this->m_oConnection = @new   mysqli($p_sHost,$p_sUsername,$p_sPassword,$p_sDatabase);

		if ($this->m_oConnection->connect_error)
		{
			throw new Exception('Connect Error (' . $this->m_oConnection->connect_errno . ') ' . $this->m_oConnection->connect_error);
			unset($this->m_oConnection);
		}
		
	}

	function __destruct()
	{
		if ($this->m_oConnection)
			$this->m_oConnection->close();
	}

	function selectDatabase($p_aRows = array(), $p_sTable = '', $p_sWhere = '', $p_bLimit = false)
	{
		
		$t_sQuery = 'SELECT ';
		if (sizeof($p_aRows))
		{
			foreach ($p_aRows as $key => $value)
			{
				if ($key > 0)
					$t_sQuery .= ',';
				$t_sQuery .= $value;
			}
		}
		else
			$t_sQuery .= '*';
			
		$t_sQuery .= ' FROM ' . $p_sTable;
		$t_sQuery .= ' WHERE ';
		if ($p_sWhere == '')
			$t_sQuery .= '1';
		else
			$t_sQuery .= $p_sWhere;
		
		//echo $t_sQuery;

		$t_oResult = $this->m_oConnection->query($t_sQuery);

		if ($t_oResult)
		{
			if ($p_bLimit)
			{
				$t_hResultSet = $t_oResult->fetch_array(MYSQLI_ASSOC);
			}
			else
			{
				while ($t_hRow = $t_oResult->fetch_array(MYSQLI_ASSOC))
				{
					$t_hResultSet[] = $t_hRow;
				}
			}

			$t_oResult->close();

			if (isset($t_hResultSet))
				return $t_hResultSet;	
		}
		else
		{
			throw new Exception('SQL Select Error (' . $this->m_oConnection->errno . ') ' . $this->m_oConnection->error);
		}

		
	}
	
	function deleteDatabase($p_sTable, $p_sWhereClause = '1')
	{

		$t_sQuery = 'DELETE FROM ' . $p_sTable . ' WHERE ' . $p_sWhereClause;

		$t_bResult = $this->m_oConnection->query($t_sQuery);
		if ($t_bResult === true)
		{
			return $this->m_oConnection->affected_rows;
		}
		else
		{
			echo('SQL Delete Error (' . $this->m_oConnection->errno . ') ' . $this->m_oConnection->error);
		}
	}
	
	function updateDatabase($p_aData=array(),$p_sTable='',$p_sWhere='')
	{

		$t_sQuery = 'UPDATE ' . $p_sTable . ' SET ';
		$i=0;
		foreach ($p_aData as $key => $value)
		{
			if ($i > 0)
				$t_sQuery .= ',';
			$t_sQuery .= $key . "= '" . $this->escapeString($value) . "'";
			$i++;
		}	
		$t_sQuery .= ' WHERE ' . ($p_sWhere == '' ? '1' : $p_sWhere);

		//echo $t_sQuery;
	    $t_bResult = $this->m_oConnection->query($t_sQuery);

		if ($t_bResult === true)
		{
			return $this->m_oConnection->affected_rows;
		}
		else
		{
			throw new Exception('SQL Update Error (' . $this->m_oConnection->errno . ') ' . $this->m_oConnection->error);
		}
	}
	
	function insertDatabase($p_aData=array(),$p_sTable='')
	{

		$t_sQuery = 'INSERT INTO ' . $p_sTable . ' ( ';
		$i=0;
		foreach ($p_aData as $key => $value)
		{
			if ($i > 0)
				$t_sQuery .= ',';
			$t_sQuery .= $key;
			$i++;
		}
		$t_sQuery .= ' ) VALUES (';
		
		$i=0;
		foreach ($p_aData as $key => $value)
		{
			if ($i > 0)
				$t_sQuery .= ',';
			$t_sQuery .= "'" . $this->escapeString($value) . "'";
			$i++;
		}
		$t_sQuery .= ' )';
		
		//echo $t_sQuery;

	   	$t_bResult = $this->m_oConnection->query($t_sQuery);
		if ($t_bResult === true)
		{
			$t_iNewID = $this->m_oConnection->insert_id;

			return $t_iNewID;
		}
		else
		{
			throw new Exception('SQL Insert Error (' . $this->m_oConnection->errno . ') ' . $this->m_oConnection->error);
		}
	}
	
	function escapeString($p_sString)
	{
		$p_sString = str_replace('Â£', '£', $p_sString);
		return $this->m_oConnection->real_escape_string($p_sString);
	}
	



}


?>
