<?php

use PHPUnit\Framework\TestCase;
use App\DB\Fields\Field;

class FieldTest extends TestCase
{
	/**
	 * Конструктор класса должен заполнять значение основных свойств
	 * canNull и defaultValue - не обязательные параметры
	 * @param Field $field
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
		return [
			[
				'field' => new Field('TEST1', true),
				'expected' => [
					'name' => 'TEST1',
					'canNull' => true,
					'default' => null
				]
			],
			[
				'field' => new Field('TEST2', true, 10),
				'expected' => [
					'name' => 'TEST2',
					'canNull' => true,
					'default' => 10
				]
			],
			[
				'field' => new Field('TEST'),
				'expected' => [
					'name' => 'TEST',
					'canNull' => false,
					'default' => null
				]
			],
		];
	}
}
