<?php

use App\Exception\FieldException;
use \PHPUnit\Framework\TestCase;
use App\DB\Fields\DatetimeField;

class DatetimeFieldTest extends TestCase
{

	/**
	 * Должна возвращать Datetime
	 * 'Y-m-d H:i:s'
	 */
	public function testFromDB()
	{
		$field = new DatetimeField('NAME');
		$this->assertInstanceOf(DateTime::class, $field->fromDB('2019-01-01 00:00:00'));
	}

	/**
	 * @param $value
	 * @param $expected
	 * @dataProvider prepareValueDataProvider
	 * @throws FieldException
	 */
	public function testGetDefaultValue($value, $expected)
	{
		$field = new DatetimeField('NAME', false, $value);
		$prepared = $field->getDefaultValue();
		$this->assertInstanceOf(DateTime::class, $prepared);
		$this->assertEquals($expected, $prepared->format('Y-m-d'));
	}

	/**
	 * @throws FieldException
	 */
	public function testToDB()
	{
		$field = new DatetimeField('NAME');
		$this->assertEquals('2019-01-01 01:02:03', $field->toDB('2019-01-01 01:02:03'));
	}

	/**
	 * @param $value
	 * @param $expected
	 * @dataProvider prepareValueDataProvider
	 * @throws FieldException
	 */
	public function testPrepareValue($value, $expected)
	{
		$field = new DatetimeField('NAME');
		$prepared = $field->prepareValue($value);
		$this->assertInstanceOf(DateTime::class, $prepared);
		$this->assertEquals($expected, $prepared->format('Y-m-d'));
	}

	public function prepareValueDataProvider(): array
	{
		return [
			'Y-m-d H:i:s' => [
				'value' => '2019-01-01 00:00:00',
				'expected' => '2019-01-01'
			],
			'Y-m-d' => [
				'value' => '2019-01-02',
				'expected' => '2019-01-02'
			],
			'd/m/Y' => [
				'value' => '02/01/2019',
				'expected' => '2019-01-02'
			],
			'd.m.Y' => [
				'value' => '02.01.2019',
				'expected' => '2019-01-02'
			],
			'd,m-Y' => [
				'value' => '02,01-2019',
				'expected' => '2019-01-02'
			],
			'DateTime' => [
				'value' => DateTime::createFromFormat('Y-m-d', '2019-01-02'),
				'expected' => '2019-01-02'
			],
		];
	}
}
