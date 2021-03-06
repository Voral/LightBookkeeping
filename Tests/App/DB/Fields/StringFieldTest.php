<?php
namespace App\DB\Fields;

use App\DB\Tables\Table;
use PHPUnit\Framework\TestCase;

class StringFieldTest extends TestCase
{

	/**
	 * Метод должен приводить данные к строковому типу
	 */
	public function testFromDB()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new StringField($table,'NAME');
		$this->assertSame("10", $field->fromDB(10));
	}

	/**
	 * Метод должен приводить данные к строковому типу. И убирать начальные и конченые пробелы
	 */
	public function testToDB()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new StringField($table,'NAME');
		$this->assertSame("'10'", $field->toDB(10));
		$this->assertSame("'testing'", $field->toDB(" \ttesting\n"));
		$this->assertSame("10", $field->prepareValue(10));
		$this->assertSame("testing", $field->prepareValue(" \ttesting\n"));
	}

	/**
	 * Метод должен приводить значение к строке
	 */
	public function testGetDefaultValue()
	{
		/** @var Table $table */
		$table = $this->getMockBuilder(Table::class)
			->disableOriginalConstructor()
			->getMock();
		$field = new StringField($table,'NAME', true, 10);
		$this->assertSame("10", $field->getDefaultValue());
	}
}
