<?php

namespace RAR\Framework\Database\Objects;

class Properties
{
	public $PropName	= null;
	public $FieldName	= null;
	public $Type		= null;
	public $PrimaryKey	= false;
	public $Size		= 0;
	public $Value		= null;

	public function __construct()
	{

	}

	public function SetValues($sPropName, $sFieldName, $sType, $sPrimaryKey, $sSize, $sValue)
	{
		$this->PropName   = $sPropName;
		$this->FieldName  = $sFieldName;
		$this->Type       = $sType;
		$this->PrimaryKey = $sPrimaryKey;
		$this->Size       = $sSize;
		$this->Value      = $sValue;
	}
}

?>