<?php

namespace App\DB\Queries;

use App\DB\Tables\AccountTable;
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
		$fieldName = 'left_margin';
		$query
			->setSelect(['id', 'name', 'a1' => 'parent_id'])
			->addSelect($fieldName)
			->addSelect($fieldName)
			->addSelect($fieldName, 'b');

		$this->assertEquals('select a.id,a.name,a.parent_id a1,a.left_margin,a.left_margin b from account a', $query->get());
	}

	/**
	 * При добавлении в селект поля несуществующее в таблице выбрасывается исключение
	 */
	public function testUndefinedField(): void
	{
		$this->expectException(FieldUndefinedException::class);
		$this->expectErrorMessage('Field abra is not defined in table account');
		$table = new AccountTable();
		$query = new SelectQuery($table);
		$query->setSelect(['abra'])->get();
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
			new Like($fieldName,'test')
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
				$query->setWhere($where1)->addWhere(new NotIsNull($fieldName),WhereGroup::LOGIC_OR)->get(),
				'select a.id from account a where (a.id=2 or a.name like \'%test%\' or not a.name is null)'
			],
		];
	}

}
