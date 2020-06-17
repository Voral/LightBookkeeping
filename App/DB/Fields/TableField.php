<?php

namespace App\DB\Fields;

use App\DB\Tables\Table;

/**
 * Базовый класс описания полей таблиц
 * Class Field
 * @package App\DB\Fields
 */
class TableField extends Field
{
	/** @var Table */
	private $table;
	/** @var boolean может принимать тип null */
	private $canNull;
	/** @var mixed занчение поля по умолчанию */
	private $defaultValue;

	/** @var bool показывать алиас таблцы */
	private static $showTableAlias = true;

	public function __construct(Table $table, string $name, bool $canNull = false, $defaultValue = null)
	{
		parent::__construct($name);
		$this->table = $table;
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

		$result = self::$showTableAlias
			? sprintf('%s.%s', $this->table->getAlias(), $this->name)
			: $this->name;
		if ($alias !== '') {
			$result .= (' ' . $alias);
		}
		return $result;
	}

	/**
	 * @param bool $showTableAlias
	 */
	public static function setShowTableAlias(bool $showTableAlias): void
	{
		self::$showTableAlias = $showTableAlias;
	}

}