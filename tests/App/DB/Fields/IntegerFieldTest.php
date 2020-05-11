<?php


use App\DB\Fields\IntegerField;
use PHPUnit\Framework\TestCase;

class IntegerFieldTest extends TestCase
{

	/**
	 * Метод должен приводить данные к типу int
	 */
	public function testFromDB()
	{
		$field = new IntegerField('NAME');
		$this->assertSame(10, $field->fromDB('10'));
	}

	/**
	 * Метод должен приводить данные к типу инт.
	 * @param $value
	 * @param $expected
	 * @dataProvider toDbDataProvider
	 */
	public function testToDB($value, $expected)
	{
		$field = new IntegerField('NAME');
		$this->assertSame($expected, $field->toDB($value));
		$this->assertSame($expected, $field->prepareValue($value));
	}

	public function toDbDataProvider():array
	{
		return [
			'integer_string' => [
				'value' => '10',
				'expected' => 10
			],
			'float' => [
				'value' => 10.4,
				'expected' => 10
			],
			'float_string' => [
				'value' => 10.4,
				'expected' => 10
			]
		];
	}
	/**
	 * Метод должен приводить значение к инт
	 */
	public function testGetDefaultValue()
	{
		$field = new IntegerField('NAME', true, '10');
		$this->assertSame(10, $field->getDefaultValue());
	}
}
