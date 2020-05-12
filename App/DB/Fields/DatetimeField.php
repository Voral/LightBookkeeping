<?php


namespace App\DB\Fields;


use DateTime;
use LogicException;

class DatetimeField extends Field
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

	public function toDB($value): string
	{
		return $this->prepareValue($value)->format(self::$format);
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return DateTime
	 */
	public function prepareValue($value): DateTime
	{
		if (is_string($value)) {
			$value = str_replace(
				['/','.',','],
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
		/** @todo Свои ексцепшены */
		throw new LogicException('Unknown value type');
	}

	public function fromDB($value): DateTime
	{
		return DateTime::createFromFormat(self::$format, $value);
	}

	public function getDefaultValue(): DateTime
	{
		return $this->prepareValue(parent::getDefaultValue());
	}
}