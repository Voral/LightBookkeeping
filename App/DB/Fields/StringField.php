<?php


namespace App\DB\Fields;

/**
 * Поле типа строка. Убираем из строки начальные и конечные прбелы и спец символы
 * первод строки, табуляция и т.п.
 * Class StringField
 * @package App\DB\Fields
 */
class StringField extends TableField
{
	public function toDB($value): string
	{
		return sprintf("'%s'",$this->quote($this->prepareValue($value)));
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return string
	 */
	public function prepareValue($value): string
	{
		return trim($value);
	}

	public function fromDB($value): string
	{
		return $value;
	}

	public function getDefaultValue(): string
	{
		return trim(parent::getDefaultValue());
	}
}