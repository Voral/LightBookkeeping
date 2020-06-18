<?php

namespace App\DB\Queries;

use App\DB\Fields\TableField;
use App\DB\Tables\AccountTable;
use App\Exception\FieldUndefinedException;
use App\Exception\QueryUpdateEmptyException;
use PHPUnit\Framework\TestCase;

/**
 * В тестах обходимся без моков, чтоб не захламлять тесты лишним кодом
 * Class DeleteQueryTest
 */
class UpdateQueryTest extends TestCase
{
	/**
	 * @param string $result
	 * @param string $expected
	 * @dataProvider getDataProvider
	 */
	public function testGet(string $result, string $expected)
	{
		$this->assertEquals($expected, $result);
	}

	/**
	 * Обязательно должно быть условие
	 * @return array|array[]
	 * @throws FieldUndefinedException
	 * @throws QueryUpdateEmptyException
	 */
	public function getDataProvider(): array
	{
		$account = new AccountTable();
		/** @var TableField $fieldId */
		$fieldId = $account->getField('id');
		/** @var TableField $fieldName */
		$fieldName = $account->getField('name');
		/** @var TableField $fieldShortName */
		$fieldShortName = $account->getField('short_name');
		$query = new UpdateQuery(
			$account,
			[new Set($fieldName, 'test')],
			new Equal($fieldId,10)
		);
		return [
			'single' => [
				$query->get(),
				'update account set name=\'test\' where id=10'
			],
			'add' => [
				$query->addSet(new Set($fieldShortName,'new short'))->get(),
				'update account set name=\'test\',short_name=\'new short\' where id=10'
			],
			'reset' => [
				$query->setSet([new Set($fieldShortName,'new short \'my\'')])->get(),
				'update account set short_name=\'new short \\\'my\\\'\' where id=10'
			],
		];
	}
}
