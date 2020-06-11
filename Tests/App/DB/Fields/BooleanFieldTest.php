<?php
namespace App\DB\Fields;


use App\DB\Tables\Table;
use PHPUnit\Framework\TestCase;

class BooleanFieldTest extends TestCase
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
		$field = new BooleanField($table,'NAME');
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
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->getMock();

		$field = new BooleanField($table, 'NAME');
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

	public function defaultDataProvider(): array
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();

		return [
			'boolean_true' => [
				new BooleanField($table, 'NAME', true, true),
				true
			],
			'boolean_false' => [
				new BooleanField($table, 'NAME', true, false),
				false
			],
			'int_1' => [
				new BooleanField($table, 'NAME', true, 1),
				true
			],
			'int_0' => [
				new BooleanField($table, 'NAME', true, 0),
				false
			]
		];
	}
}
