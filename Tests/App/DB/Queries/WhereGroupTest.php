<?php

namespace App\DB\Queries;

use App\DB\Tables\AccountTable;
use App\Exception\AppException;
use App\Exception\FieldUndefinedException;
use App\Exception\QueryUnknownLogicException;
use PHPUnit\Framework\TestCase;

class WhereGroupTest extends TestCase
{

	/**
	 * Исключение если неизвестный тип логики
	 * @throws FieldUndefinedException
	 * @throws QueryUnknownLogicException
	 */
	public function testFabricException(){

		$account = new AccountTable();
		$fieldId = $account->getField('id');
		$fieldName = $account->getField('name');
		$where = [
			new Equal($fieldId, 2),
			new Like($fieldName,'test')
		];
		$this->expectException(QueryUnknownLogicException::class);
		$this->expectExceptionCode(AppException::QUERIES_UNKNOWN_LOGIC);
		WhereGroup::fabric($where,'unknown');
	}
	/**
	 * @param string $where
	 * @param string $expected
	 * @dataProvider fabricDataProvider
	 */
	public function testFabric(string $where, string $expected)
	{
		$this->assertEquals($expected, $where);
	}

	/**
	 * Генерация класса в зависимости от параметра
	 * @return array[]
	 * @throws FieldUndefinedException
	 * @throws QueryUnknownLogicException
	 */
	public function fabricDataProvider()
	{
		$account = new AccountTable();
		$fieldId = $account->getField('id');
		$fieldName = $account->getField('name');
		$where = [
			new Equal($fieldId, 2),
			new Like($fieldName,'test')
		];
		return [
			'and' => [
				WhereGroup::fabric($where,WhereGroup::LOGIC_AND)->get(),
				'(a.id=2 and a.name like \'%test%\')'
			],
			'or' => [
				WhereGroup::fabric($where,WhereGroup::LOGIC_OR)->get(),
				'(a.id=2 or a.name like \'%test%\')'
			],
		];

	}
}
