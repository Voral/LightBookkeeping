<?php


namespace App\Exception;


class FieldException extends AppException
{
	private $value;
	private $fieldClass;

	/**
	 * FieldException constructor.
	 * @param string $message
	 * @param mixed $value
	 * @param string $className
	 */
	public function __construct($message = "", $value = null, string $className = '')
	{
		$this->value = $value;
		$this->fieldClass = $className;
		parent::__construct($message);
	}

	/**
	 * @return string
	 */
	public function getFieldClass(): string
	{
		return $this->fieldClass;
	}

	/**
	 * @return mixed
	 */
	public function getValue()
	{
		return $this->value;
	}
}