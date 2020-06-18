<?php
namespace App\DB\Fields;

use App\DB\Tables\Table;
use App\Exception\FieldValueException;
use DateTime;
use \PHPUnit\Framework\TestCase;

class DatetimeFieldTest extends TestCase
{

	/**
	 * Должна возвращать Datetime
	 * 'Y-m-d H:i:s'
	 */
	public function testFromDB()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new DatetimeField($table,'NAME');
		$this->assertInstanceOf(DateTime::class, $field->fromDB('2019-01-01 00:00:00'));
	}

	/**
	 * @param $value
	 * @param $expected
	 * @dataProvider prepareValueDataProvider
	 * @throws FieldValueException
	 */
	public function testGetDefaultValue($value, $expected)
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new DatetimeField($table,'NAME', false, $value);
		$prepared = $field->getDefaultValue();
		$this->assertInstanceOf(DateTime::class, $prepared);
		$this->assertEquals($expected, $prepared->format('Y-m-d'));
	}

	/**
	 * @throws FieldValueException
	 */
	public function testToDB()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new DatetimeField($table,'NAME');
		$this->assertEquals("'2019-01-01 01:02:03'", $field->toDB('2019-01-01 01:02:03'));
	}

	/**
	 * @param $value
	 * @param $expected
	 * @dataProvider prepareValueDataProvider
	 * @throws FieldValueException
	 */
	public function testPrepareValue($value, $expected)
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();

		$field = new DatetimeField($table,'NAME');
		$prepared = $field->prepareValue($value);
		$this->assertInstanceOf(DateTime::class, $prepared);
		$this->assertEquals($expected, $prepared->format('Y-m-d'));
	}

	public function prepareValueDataProvider(): array
	{
		return [
			'Y-m-d H:i:s' => [
				'2019-01-01 00:00:00',
				'2019-01-01'
			],
			'Y-m-d' => [
				'2019-01-02',
				'2019-01-02'
			],
			'd/m/Y' => [
				'02/01/2019',
				'2019-01-02'
			],
			'd.m.Y' => [
				'02.01.2019',
				'2019-01-02'
			],
			'd,m-Y' => [
				'02,01-2019',
				'2019-01-02'
			],
			'DateTime' => [
				DateTime::createFromFormat('Y-m-d', '2019-01-02'),
				'2019-01-02'
			],
		];
	}
}
