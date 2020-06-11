<?php
namespace App\DB\Queries;


use App\DB\Tables\AccountTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;

class EqualTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		$where = new Equal($journal->getField('id'), $journal->getField('account_src_id'));
		$this->assertEquals(WhereItem::TYPE_EQUAL, $where->getType());
	}

	/**
	 * @param Equal $where
	 * @param string $expected
	 * @dataProvider getDataProvider
	 */
	public function testGet(Equal $where, $expected)
	{
		$this->assertEquals($expected, $where->get());
	}

	/**
	 * - Проверяемое поле должно быть салиасом таблицы
	 * - Выражение проверки знак равенства
	 * - Если партнер инстас типа Field то название поля с алиасом таблицы
	 * - если строка подставляется без изменений
	 * @return array[]
	 * @throws FieldUndefinedException
	 */
	public function getDataProvider()
	{
		$journal = new JournalTable();
		$account = new AccountTable();
		return [
			'single' => [
				'where' => new Equal($journal->getField('id'), $journal->getField('account_src_id')),
				'expected' => 'j.id=j.account_src_id'
			],
			'singleOtherTable' => [
				'where' => new Equal($journal->getField('id'), $account->getField('id')),
				'expected' => 'j.id=a.id'
			],
			'string' => [
				'where' => new Equal($journal->getField('id'), 'now()'),
				'expected' => 'j.id=now()'
			],
		];
	}
}
