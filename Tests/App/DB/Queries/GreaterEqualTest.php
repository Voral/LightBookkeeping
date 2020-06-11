<?php


use App\DB\Queries\GreaterEqual;
use App\DB\Queries\WhereItem;
use App\DB\Tables\AccountTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;

class GreaterEqualTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		$where = new GreaterEqual($journal->getField('id'), $journal->getField('account_src_id'));
		$this->assertEquals(WhereItem::TYPE_GREATER_EQUAL, $where->getType());
	}

	/**
	 * @param GreaterEqual $where
	 * @param string $expected
	 * @dataProvider getDataProvider
	 */
	public function testGet(GreaterEqual $where, $expected)
	{
		$this->assertEquals($expected, $where->get());
	}

	/**
	 * - Проверяемое поле должно быть салиасом таблицы
	 * - Выражение проверки знак больше или равно
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
				new GreaterEqual($journal->getField('id'), $journal->getField('account_src_id')),
				'j.id>=j.account_src_id'
			],
			'singleOtherTable' => [
				new GreaterEqual($journal->getField('id'), $account->getField('id')),
				'j.id>=a.id'
			],
			'string' => [
				new GreaterEqual($journal->getField('id'), 'now()'),
				'j.id>=now()'
			],
		];
	}
}
