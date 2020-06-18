<?php


namespace App\DB\Fields;

/**
 * Поле типа boolean. В базе храниться как 1 и 0.
 * Class BooleanField
 * @package App\DB\Fields
 */
class BooleanField extends TableField
{
	/**
	 * Переопределено для установки типа результата
	 * @param $value
	 * @return int
	 */
	public function toDB($value): int
	{
		return 0 === (int)$value ? 0 : 1;
	}

	/**
	 * Переопределено для установки типа результата
	 * @param $value
	 * @return bool
	 */
	public function fromDB($value): bool
	{
		return $value;
	}

	/**
	 * Возвращает значение поля по умолчанию
	 * Переопределено для установки типа результата
	 * @return bool
	 */
	public function getDefaultValue(): bool
	{
		return (bool)parent::getDefaultValue();
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return bool
	 */
	public function prepareValue($value): bool
	{
		return $value;
	}
}