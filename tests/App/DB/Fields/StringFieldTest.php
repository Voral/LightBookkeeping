<?php


use App\DB\Fields\StringField;
use PHPUnit\Framework\TestCase;

class StringFieldTest extends TestCase
{

	/**
	 * Метод должен приводить данные к строковому типу
	 */
	public function testFromDB()
	{
		$field = new StringField('NAME');
		$this->assertSame('10', $field->fromDB(10));
	}

	/**
	 * Метод должен приводить данные к строковому типу. И убирать начальные и конченые пробелы
	 */
	public function testToDB()
	{
		$field = new StringField('NAME');
		$this->assertSame('10', $field->toDB(10));
		$this->assertSame('testing', $field->toDB(" \ttesting\n"));
	}

	/**
	 * Метод должен приводить значение к строке
	 */
	public function testGetDefaultValue()
	{
		$field = new StringField('NAME', true, 10);
		$this->assertSame('10', $field->getDefaultValue());
	}
}
