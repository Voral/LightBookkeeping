<?php
namespace App\DB\Queries;
use App\DB\Tables\AccountTable;
use App\Exception\FieldUndefinedException;
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
}
