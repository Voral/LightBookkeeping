<?php


namespace App\Exception;

/**
 * В поле передано значение, которое не может быть принято данным типом поля
 * Class FieldValueException
 * @package App\Exception
 */
class FieldValueException extends AppException
{
	/** @var mixed|null Переданное значение */
	private $value;
	/** @var string Класс поля */
	private $fieldClass;

	/**
	 * FieldException constructor.
	 * @param mixed $value
	 * @param string $className
	 */
	public function __construct($value = null, string $className = '')
	{

		parent::__construct(
			sprintf('Invalid value type for field type (%s)',$className),
			AppException::FIELD_UNKNOWN_VALUE_TYPE
		);
		$this->value = $value;
		$this->fieldClass = $className;
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