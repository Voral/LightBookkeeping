<?php

namespace App\DB\Fields;

use App\DB\Tables\Table;

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
	/** @var Table */
	private $table;

	public function __construct(Table $table, string $name, bool $canNull = false, $defaultValue = null)
	{
		$this->table = $table;
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
		return $this->prepareValue($value);
	}

	/**
	 * Подготовка значения для вставки в запрос
	 * @param $value
	 * @return mixed
	 */
	public function sqlValue($value)
	{
		return $this->toDB($value);
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return mixed
	 */
	public function prepareValue($value)
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

	public function sqlField(string $alias = ''): string
	{
		$result = sprintf('%s.%s', $this->table->getAlias(), $this->name);
		if ($alias !== ''){
			$result .= (' '.$alias);
		}
 		return $result;
	}
}