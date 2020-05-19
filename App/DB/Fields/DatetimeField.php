<?php


namespace App\DB\Fields;


use App\Exception\FieldException;
use DateTime;

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

	/**
	 * @param $value
	 * @return string
	 * @throws FieldException
	 */
	public function toDB($value): string
	{
		return $this->prepareValue($value)->format(self::$format);
	}

	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return DateTime
	 * @throws FieldException
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
		throw new FieldException('Unknown value type',$value,self::class);
	}

	public function fromDB($value): DateTime
	{
		return DateTime::createFromFormat(self::$format, $value);
	}

	/**
	 * @return DateTime
	 * @throws FieldException
	 */
	public function getDefaultValue(): DateTime
	{
		return $this->prepareValue(parent::getDefaultValue());
	}
}