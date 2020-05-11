<?php


use App\DB\Fields\FloatField;
use PHPUnit\Framework\TestCase;

class FloatFieldTest extends TestCase
{

	/**
	 * Метод должен приводить данные к типу float
	 */
	public function testFromDB()
	{
		$field = new FloatField('NAME');
		$this->assertSame(10.2, $field->fromDB('10.2'));
	}

	/**
	 * Метод должен приводить данные к типу float.
	 * Заменять , на .
	 * @param $value
	 * @param $expected
	 * @dataProvider toDbDataProvider
	 */
	public function testToDB($value,$expected)
	{
		$field = new FloatField('NAME');
		$this->assertSame($expected, $field->toDB($value));
		$this->assertSame($expected, $field->prepareValue($value));
	}
	public function toDbDataProvider()
	{
		return [
			'double' => [
				'value' => 10.2,
				'expected' => 10.2
			],
			'string' => [
				'value' => ' 10.3',
				'expected' => 10.3
			],
			'string_comma' => [
				'value' => ' 10,4',
				'expected' => 10.4
			],
		];
	}

	/**
	 * Метод должен приводить значение к float
	 */
	public function testGetDefaultValue()
	{
		$field = new FloatField('NAME', true, '10.3');
		$this->assertSame(10.3, $field->getDefaultValue());
	}
}
