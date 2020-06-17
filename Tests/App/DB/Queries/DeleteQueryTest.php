<?php

namespace App\DB\Queries;

use App\DB\Tables\AccountTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;

/**
 * В тестах обходимся без моков, чтоб не захламлять тесты лишним кодом
 * Class DeleteQueryTest
 */
class DeleteQueryTest extends TestCase
{
	/**
	 * @throws FieldUndefinedException
	 */
	public function testGet()
	{
		$account = new AccountTable();
		$fieldId = $account->getField('id');
		$query = new DeleteQuery($account, new Greater($fieldId,10));
		$this->assertEquals(
			'delete from account where id>10',
			$query->get()
		);
	}
}
