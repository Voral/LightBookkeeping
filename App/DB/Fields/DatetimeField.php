<?php

namespace App\DB\Fields;

use App\Exception\FieldValueException;
use DateTime;

class DatetimeField extends TableField
{
	private static $format = 'Y-m-d H:i:s';
	private static $checkFormat = [
		'Y-m-d',
		'd/m/Y',
		'd.m.Y',
		'd,m,Y',
		'd-m-Y',
		'Y-m-d H:i:s',
	];

	/**
	 * @param $value
	 * @return string
	 * @throws FieldValueException
	 */
	public function toDB($value): string
	{
		return sprintf(
			"'%s'",
			$this->prepareValue($value)->format(self::$format)
		);
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return DateTime
	 * @throws FieldValueException
	 */
	public function prepareValue($value): DateTime
	{
		if (is_string($value)) {
			$value = str_replace(
				['/', '.', ','],
				'-',
				$value
			);
			foreach (self::$checkFormat as $format) {
				if ($result = DateTime::createFromFormat($format, $value)) {
					return $result;
				}
			}
		} elseif ($value instanceof DateTime) {
			return $value;
		}
		throw new FieldValueException($value, self::class);
	}

	public function fromDB($value): DateTime
	{
		return DateTime::createFromFormat(self::$format, $value);
	}

	/**
	 * @return DateTime
	 * @throws FieldValueException
	 */
	public function getDefaultValue(): DateTime
	{
		return $this->prepareValue(parent::getDefaultValue());
	}
}