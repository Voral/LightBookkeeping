<?php


namespace App\Exception;


use Exception;
use Throwable;

class AppException extends Exception
{
	public const UNKNOWN = 1;
	public const FIELD_UNKNOWN_VALUE_TYPE = 10000;
	public const FIELD_UNDEFINED = 10001;
	public const QUERIES_EMPTY_ARRAY = 15000;
	public const QUERIES_UNKNOWN_LOGIC = 15001;
	public const QUERIES_EMPTY_UPDATE = 15002;
	public const ENTITY_FIELD_UNKNOWN = 20000;
	public const CONFIG_WRONG = 25000;
	public const CONFIG_UNKNOWN_KEY = 25001;

	public function __construct($message = '', $code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}