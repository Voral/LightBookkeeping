<?php

namespace App\DB\Queries;

use App\DB\Fields\RuntimeField;
use App\DB\Tables\AccountTable;
use App\DB\Tables\JournalTable;
use App\Exception\FieldUndefinedException;
use App\Exception\QueryUnknownLogicException;
use PHPUnit\Framework\TestCase;

/**
 * В тестах обходимся без моков, чтоб не захламлять тесты лишним кодом
 * Class SelectQueryTest
 */
class SelectQueryTest extends TestCase
{
	/**
	 * Простейший запрос должен возвращать только id
	 */
	public function testSingleSql(): void
	{
		$table = new AccountTable();
		$query = new SelectQuery($table);
		$this->assertEquals('select a.id from account a', $query->get());
	}

	/**
	 * Выборка конкретных полей, частично с алиасом, исключение дуюлей
	 */
	public function testAliasSql(): void
	{
		$table = new AccountTable();
		$query = new SelectQuery($table);
		$field = $table->getField('left_margin');
		$query
			->setSelect([
				$table->getField('id'),
				$table->getField('name'),
				'a1' => $table->getField('parent_id')
			])
			->addSelect($field)
			->addSelect($field)
			->addSelect($field, 'b');

		$this->assertEquals('select a.id,a.name,a.parent_id a1,a.left_margin,a.left_margin b from account a', $query->get());
	}

	/**
	 * @param string $result
	 * @param string $expected
	 * @dataProvider whereDataProvider
	 */
	public function testWhere(string $result, string $expected)
	{
		$this->assertEquals($result, $expected);
	}

	/**
	 * - проверяем простое добавление
	 * - простое доабвление группы условий
	 * - добавление условия по умолчанию AND
	 * - добавление условия в группу с иной логикой - добавляет скобки
	 * - добавление условия в группу с аналогичной логикой - без скобок
	 * @return array[]
	 * @throws FieldUndefinedException
	 * @throws QueryUnknownLogicException
	 */
	public function whereDataProvider()
	{
		$account = new AccountTable();
		$query = new SelectQuery($account);
		$fieldId = $account->getField('id');
		$fieldName = $account->getField('name');
		$where1 = new WhereGroupOr([
			new Equal($fieldId, 2),
			new Like($fieldName, 'test')
		]);
		$where = new Equal($fieldId, 1);
		return [
			'single' => [
				$query->setWhere($where)->get(),
				'select a.id from account a where a.id=1'
			],
			'doubleReplace' => [
				$query->setWhere($where1)->get(),
				'select a.id from account a where (a.id=2 or a.name like \'%test%\')'
			],
			'addDefault' => [
				$query->setWhere($where)->addWhere(new NotIsNull($fieldName))->get(),
				'select a.id from account a where (a.id=1 and not a.name is null)'
			],
			'addOther' => [
				$query->setWhere($where1)->addWhere(new NotIsNull($fieldName))->get(),
				'select a.id from account a where ((a.id=2 or a.name like \'%test%\') and not a.name is null)'
			],
			'addSame' => [
				$query->setWhere($where1)->addWhere(new NotIsNull($fieldName), WhereGroup::LOGIC_OR)->get(),
				'select a.id from account a where (a.id=2 or a.name like \'%test%\' or not a.name is null)'
			],
		];
	}

	public function testGroup()
	{
		$account = new AccountTable();
		$query = new SelectQuery($account);
		$query
			->setSelect([
				$account->getField('name'),
				$account->getField('short_name'),
				new RuntimeField('max_id', 'max(%s)', [$account->getField('id')])
			])
			->setGroup([
				$account->getField('name'),
				$account->getField('short_name')
			]);
		$this->assertEquals(
			'select a.name,a.short_name,max(a.id) max_id from account a group by a.name,a.short_name',
			$query->get()
		);
	}

	public function testOrder()
	{
		$account = new AccountTable();
		$query = new SelectQuery($account);
		$query
			->setSelect([
				$account->getField('name'),
				$account->getField('short_name'),
			])
			->setOrder([
				$account->getField('short_name'),
				$account->getField('name')
			]);
		$this->assertEquals(
			'select a.name,a.short_name from account a order by a.short_name,a.name',
			$query->get()
		);
	}

	/**
	 * @param string $result
	 * @param string $expected
	 * @dataProvider joinDataProvider
	 */
	public function testJoin(string $result, string $expected)
	{
		$this->assertEquals($result, $expected);
	}

	/**
	 * - формирование join запроса
	 * - если таблица добавляется повторно - к алиасу добавляется цифровой суффикс
	 * @return array[]
	 * @throws FieldUndefinedException
	 */
	public function joinDataProvider()
	{
		$account1 = new AccountTable();
		$account2 = new AccountTable();
		$journal = new JournalTable();
		$query = new SelectQuery($journal);
		$fieldAccId1 = $account1->getField('id');
		$fieldAccId2 = $account2->getField('id');
		$fieldJrnSrcId = $journal->getField('account_src_id');
		$fieldJrnDstId = $journal->getField('account_dst_id');
		return [
			'single' => [
				$query->setJoin([new JoinLeft($account1, new Equal($fieldAccId2, $fieldJrnDstId))])->get(),
				'select j.id from journal j left join account a on a.id=j.account_dst_id'
			],
			'add' => [
				$query
					->setJoin([new JoinLeft($account1, new Equal($fieldAccId1, $fieldJrnDstId))])
					->addJoin(new JoinLeft($account2, new Equal($fieldAccId2, $fieldJrnSrcId)))
					->get(),
				'select j.id from journal j left join account a on a.id=j.account_dst_id left join account a1 on a1.id=j.account_src_id'
			],
		];
	}

	/**
	 * @param string $actual
	 * @param string $expected
	 * @dataProvider limitDataProvider
	 */
	public function testLimit(string $actual, string $expected): void
	{
		$this->assertEquals($expected, $actual);
	}

	/**
	 * @return array[]
	 * @throws FieldUndefinedException
	 */
	public function limitDataProvider(): array
	{
		$account = new AccountTable();
		return [
			'rows' => [
				(new SelectQuery($account))->setRowCount(10)->get(),
				'select a.id from account a limit 10'
			],
			'offset' => [
				(new SelectQuery($account))->setOffset(5)->get(),
				sprintf('select a.id from account a limit 5,%d', PHP_INT_MAX)
			],
			'both' => [
				(new SelectQuery($account))->setRowCount(20)->setOffset(6)->get(),
				'select a.id from account a limit 6,20'
			]
		];
	}
}
