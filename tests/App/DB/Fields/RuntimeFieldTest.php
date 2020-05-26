<?php

use App\DB\Fields\RuntimeField;
use App\DB\Tables\AccountTable;
use App\DB\Tables\JournalTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;

class RuntimeFieldTest extends TestCase
{
	/**
	 * @param RuntimeField $field
	 * @param string $expected
	 * @dataProvider sqlFieldDataProvider
	 */
	public function testSqlField($field, $expected)
	{
		$this->assertEquals($expected, $field->sqlField());
	}

	/**
	 * @return array
	 * @throws FieldUndefinedException
	 */
	public function sqlFieldDataProvider()
	{
		$table = new AccountTable();
		$tableJournal = new JournalTable();
		return [
			'oneTableNoField' => [
				'field' => new RuntimeField('test', 'now()', []),
				'expected' => 'now() test'
			],
			'oneTableOneField' => [
				'field' => new RuntimeField('test', 'sum(%s)', [
					$table->getField('id')
				]),
				'expected' => 'sum(a.id) test'
			],
			'oneTableTwoField' => [
				'field' => new RuntimeField('test', '%s + %s', [
					$table->getField('id'),
					$table->getField('parent_id')
				]),
				'expected' => 'a.id + a.parent_id test'
			],
			'twoTableTwoField' => [
				'field' => new RuntimeField('test', '%s + %s', [
					$table->getField('id'),
					$tableJournal->getField('id')
				]),
				'expected' => 'a.id + j.id test'
			]
		];
	}
}
