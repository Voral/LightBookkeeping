<?php


namespace App\DB\Fields;


class IntegerField extends Field
{
	public function toDB($value): int
	{
		return $this->prepareValue($value);
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return int
	 */
	public function prepareValue($value):int
	{
		return $value;
	}

	public function fromDB($value): int
	{
		return $value;
	}

	public function getDefaultValue():int
	{
		return parent::getDefaultValue();
	}
}