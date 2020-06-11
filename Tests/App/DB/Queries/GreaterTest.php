<?php
namespace App\DB\Queries;


use App\DB\Tables\AccountTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;

class GreaterTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		$where = new Greater($journal->getField('id'), $journal->getField('account_src_id'));
		$this->assertEquals(WhereItem::TYPE_GREATER, $where->getType());
	}

	/**
	 * @param Greater $where
	 * @param string $expected
	 * @dataProvider getDataProvider
	 */
	public function testGet(Greater $where, $expected)
	{
		$this->assertEquals($expected, $where->get());
	}

	/**
	 * - Проверяемое поле должно быть салиасом таблицы
	 * - Выражение проверки знак больше
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
				new Greater($journal->getField('id'), $journal->getField('account_src_id')),
				'j.id>j.account_src_id'
			],
			'singleOtherTable' => [
				new Greater($journal->getField('id'), $account->getField('id')),
				'j.id>a.id'
			],
			'string' => [
				new Greater($journal->getField('id'), 'now()'),
				'j.id>now()'
			],
		];
	}
}
