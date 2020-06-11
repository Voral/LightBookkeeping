<?php
namespace App\DB\Fields;

use App\DB\Tables\Table;
use PHPUnit\Framework\TestCase;

class IntegerFieldTest extends TestCase
{

	/**
	 * Метод должен приводить данные к типу int
	 */
	public function testFromDB()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new IntegerField($table,'NAME');
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
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new IntegerField($table,'NAME');
		$this->assertSame($expected, $field->toDB($value));
		$this->assertSame($expected, $field->prepareValue($value));
	}

	public function toDbDataProvider():array
	{
		return [
			'integer_string' => [
				'10',
				10
			],
			'float' => [
				10.4,
				10
			],
			'float_string' => [
				10.4,
				10
			]
		];
	}
	/**
	 * Метод должен приводить значение к инт
	 */
	public function testGetDefaultValue()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new IntegerField($table,'NAME', true, '10');
		$this->assertSame(10, $field->getDefaultValue());
	}
}
