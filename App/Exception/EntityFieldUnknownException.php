<?php


namespace App\Exception;

/**
 * Попытка установить значение для не существующего свойства
 * Class EntityFieldUnknownException
 * @package App\Exception
 */
class EntityFieldUnknownException extends AppException
{
	private $fieldName;
	private $className;
	public function __construct($fieldName,$className)
	{
		parent::__construct(
			sprintf(
				'Attempt to set a value for a unknown field %s (%s)',
				$fieldName,
				$className
			),
			AppException::ENTITY_FIELD_UNKNOWN
		);
		$this->fieldName = $fieldName;
		$this->className = $className;
	}

	/**
	 * @return mixed
	 */
	public function getClassName()
	{
		return $this->className;
	}

	/**
	 * @return mixed
	 */
	public function getFieldName()
	{
		return $this->fieldName;
	}
}