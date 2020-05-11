<?php


namespace App\DB\Fields;

/**
 * Поле типа boolean. В базе храниться как 1 и 0.
 * Class BooleanField
 * @package App\DB\Fields
 */
class BooleanField extends Field
{
	public function toDB($value): int
	{
		return $this->prepareValue($value);
	}

	public function fromDB($value): bool
	{
		return $value;
	}

	public function getDefaultValue(): bool
	{
		return parent::getDefaultValue();
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