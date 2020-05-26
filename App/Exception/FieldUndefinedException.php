<?php


namespace App\Exception;

/**
 * В поле передано значение, которое не может быть принято данным типом поля
 * Class FieldValueException
 * @package App\Exception
 */
class FieldUndefinedException extends AppException
{
	/** @var string Наименование таблицы */
	private $tableName;
	/** @var string Наименование поля */
	private $fieldName;

	/**
	 * FieldUndefinedException constructor.
	 * @param string $tableName
	 * @param string $fieldName
	 */
	public function __construct(string $tableName, string $fieldName)
	{

		parent::__construct(
			sprintf('Field %s is not defined in table %s', $fieldName, $tableName),
			AppException::FIELD_UNKNOWN_VALUE_TYPE
		);
		$this->fieldName = $fieldName;
		$this->tableName = $tableName;
	}

	/**
	 * @return string
	 */
	public function getFieldName(): string
	{
		return $this->fieldName;
	}

	/**
	 * @return mixed
	 */
	public function getTableName()
	{
		return $this->tableName;
	}
}