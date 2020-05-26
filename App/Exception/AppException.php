<?php


namespace App\Exception;


use Exception;
use Throwable;

class AppException extends Exception
{
	public const UNKNOWN = 1;
	public const FIELD_UNKNOWN_VALUE_TYPE = 10000;

	public function __construct($message = '',$code = 0, Throwable $previous = null)
	{
		parent::__construct($message, $code, $previous);
	}
}