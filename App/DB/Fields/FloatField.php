<?php


namespace App\DB\Fields;


class FloatField extends Field
{
	public function toDB($value): float
	{
		return $this->prepareValue($value);
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return float
	 */
	public function prepareValue($value): float
	{
		return trim(str_replace(',', '.', $value));
	}

	public function fromDB($value): float
	{
		return $value;
	}

	public function getDefaultValue(): float
	{
		return parent::getDefaultValue();
	}
}