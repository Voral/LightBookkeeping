<?php


namespace App\DB\Fields;


class StringField extends Field
{
	public function toDB($value): string
	{
		return trim($value);
	}

	public function fromDB($value): string
	{
		return $value;
	}

	public function getDefaultValue():string
	{
		return parent::getDefaultValue();
	}
}