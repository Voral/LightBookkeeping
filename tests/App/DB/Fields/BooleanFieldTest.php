<?php


use App\DB\Fields\BooleanField;
use PHPUnit\Framework\TestCase;

class BooleanFieldTest extends TestCase
{

	/**
	 * Метод должен приводить данные к типу int
	 */
	public function testFromDB()
	{
		$field = new BooleanField('NAME');
		$this->assertSame(true, $field->fromDB('1'));
		$this->assertSame(true, $field->fromDB(1));
		$this->assertSame(false, $field->fromDB('0'));
		$this->assertSame(false, $field->fromDB(0));
	}

	/**
	 * Метод должен приводить данные к типу boolean.
	 */
	public function testToDB()
	{
		$field = new BooleanField('NAME');
		$this->assertSame(1, $field->toDB(true));
		$this->assertSame(0, $field->toDB(false));
	}

	/**
	 * Метод должен приводить значение к boolean
	 * @param BooleanField $field
	 * @param bool $expected
	 * @dataProvider defaultDataProvider
	 */
	public function testGetDefaultValue(BooleanField $field, bool $expected)
	{
		$this->assertSame($expected, $field->getDefaultValue());
	}

	public function defaultDataProvider():array {
		return [
			'boolean_true' => 		[
				'field' => new BooleanField('NAME', true, true),
				'expected' => true
			],
			'boolean_false' => [
				'field' => new BooleanField('NAME', true, false),
				'expected' => false
			],
			'int_1' => [
				'field' => new BooleanField('NAME', true, 1),
				'expected' => true
			],
			'int_0' => [
				'field' => new BooleanField('NAME', true, 0),
				'expected' => false
			]
		];
	}
}
