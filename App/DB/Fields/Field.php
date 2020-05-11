<?php


namespace App\DB\Fields;


/**
 * Базовый класс описания полей таблиц
 * Class Field
 * @package App\DB\Fields
 */
class Field
{
	/** @var String имя поля */
	private $name;
	/** @var boolean может принимать тип null */
	private $canNull;
	/** @var mixed занчение поля по умолчанию */
	private $defaultValue;

	public function __construct(String $name, bool $canNull = false, $defaultValue = null)
	{
		$this->name = $name;
		$this->canNull = $canNull;
		$this->defaultValue = $defaultValue;
	}

	/**
	 * Возвращает значение поля по умолчанию
	 * @return mixed
	 */
	public function getDefaultValue()
	{
		return $this->defaultValue;
	}

	/**
	 * @return String
	 */
	public function getName(): String
	{
		return $this->name;
	}

	/**
	 * Возвращает может ли быть занчение null
	 * @return bool
	 */
	public function isCanNull(): bool
	{
		return $this->canNull;
	}

	/**
	 * Подготовка значения для запись в БД
	 * @param $value
	 * @return mixed
	 */
	public function toDB($value)
	{
		return $value;
	}

	/**
	 * Преобразование значения полученного из БД
	 * @param $value
	 * @return mixed
	 */
	public function fromDB($value)
	{
		return $value;
	}
}