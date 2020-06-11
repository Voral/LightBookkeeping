<?php
namespace App\DB\Fields;

use App\DB\Tables\Table;
use PHPUnit\Framework\TestCase;

class MoneyFieldTest extends TestCase
{
	/**
	 * Метод должен приводить данные к типу float.
	 * Заменять , на .
	 * @param $value
	 * @param $expected
	 * @dataProvider toDbDataProvider
	 */
	public function testToDB($value,$expected)
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new MoneyField($table,'NAME');
		$this->assertEquals($expected, $field->prepareValue($value));
	}
	public function toDbDataProvider()
	{
		return [
			[
				10.2551,
				10.26
			],
			[
				-10.2551,
				-10.26
			],
			[
				' 10.25',
				10.25
			],
			[
				' 10,0001',
				10.00
			],
		];
	}
}
