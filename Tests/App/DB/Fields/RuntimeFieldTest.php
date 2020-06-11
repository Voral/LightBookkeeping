<?php
namespace App\DB\Fields;

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
				new RuntimeField('test', 'now()', []),
				'now() test'
			],
			'oneTableOneField' => [
				new RuntimeField('test', 'sum(%s)', [
					$table->getField('id')
				]),
				'sum(a.id) test'
			],
			'oneTableTwoField' => [
				new RuntimeField('test', '%s + %s', [
					$table->getField('id'),
					$table->getField('parent_id')
				]),
				'a.id + a.parent_id test'
			],
			'twoTableTwoField' => [
				new RuntimeField('test', '%s + %s', [
					$table->getField('id'),
					$tableJournal->getField('id')
				]),
				'a.id + j.id test'
			]
		];
	}
}
