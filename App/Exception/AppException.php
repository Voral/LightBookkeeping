<?php


namespace App\Exception;


use Exception;
use Throwable;

class AppException extends Exception
{
	public const UNKNOWN = 1;
	public const FIELD_UNKNOWN_VALUE_TYPE = 10000;
	public const FIELD_UNDEFINED = 10001;
	public const QUERIES_EMPTY_ARRAY = 20000;
	public const QUERIES_UNKNOWN_LOGIC = 20001;

	public function __construct($message = '',$code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}