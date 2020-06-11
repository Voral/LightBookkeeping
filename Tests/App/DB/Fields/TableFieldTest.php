<?php
namespace App\DB\Fields;

use App\DB\Tables\Table;
use PHPUnit\Framework\TestCase;

class TableFieldTest extends TestCase
{
	/**
	 * Конструктор класса должен заполнять значение основных свойств
	 * canNull и defaultValue - не обязательные параметры
	 * @param TableField $field
	 * @param array $expected
	 * @dataProvider constructDataProvider
	 */
	public function test__construct($field, $expected)
	{
		$this->assertSame($expected['name'], $field->getName());
		$this->assertSame($expected['canNull'], $field->isCanNull());
		$this->assertSame($expected['default'], $field->getDefaultValue());
	}

	public function constructDataProvider()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		return [
			[
				'field' => new TableField($table, 'TEST1', true),
				'expected' => [
					'name' => 'TEST1',
					'canNull' => true,
					'default' => null
				]
			],
			[
				'field' => new TableField($table, 'TEST2', true, 10),
				'expected' => [
					'name' => 'TEST2',
					'canNull' => true,
					'default' => 10
				]
			],
			[
				'field' => new TableField($table, 'TEST'),
				'expected' => [
					'name' => 'TEST',
					'canNull' => false,
					'default' => null
				]
			],
		];
	}

	/**
	 * Должно возвращать наименование поле с алиасами таблицы и, если задано, алиасом
	 * поля
	 * @param $result
	 * @param $expected
	 * @dataProvider sqlFieldDataProvider
	 */
	public function testSqlField($result, $expected)
	{
		$this->assertEquals($expected, $result);
	}

	public function sqlFieldDataProvider()
	{
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$table->method('getAlias')->willReturn('ab');
		/** @var Table $table */
		$field = new TableField($table, 'TEST1', true);
		return [
			'single' => [
				$field->sqlField(),
				'ab.TEST1'
			],
			'alias' => [
				$field->sqlField('al'),
				'ab.TEST1 al'
			],
		];
	}
}
