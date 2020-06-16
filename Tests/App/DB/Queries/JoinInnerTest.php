<?php

namespace App\DB\Queries;

use App\DB\Tables\AccountTable;
use App\DB\Tables\JournalTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;

class JoinInnerTest extends TestCase
{

	/**
	 * @param Join $join
	 * @param string $expected
	 * @dataProvider getDataProvider
	 */
	public function testGet(Join $join, string $expected)
	{
		$this->assertEquals($expected, $join->get());
	}

	/**
	 * @return array[]
	 * @throws FieldUndefinedException
	 */
	public function getDataProvider()
	{
		$account = new AccountTable();
		$journal = new JournalTable();
		$accFieldId = $account->getField('id');
		$jrnSrcId = $journal->getField('account_src_id');
		$jrnDstId = $journal->getField('account_dst_id');
		return [
			'single' => [
				new JoinInner($journal, new Equal($accFieldId, $jrnSrcId)),
				'inner join journal j on a.id=j.account_src_id'
			],
			'doubleExpresion' => [
				new JoinInner($journal, new WhereGroupAnd([
					new Equal($accFieldId, $jrnSrcId),
					new NotIsNull($jrnDstId)
				])),
				'inner join journal j on (a.id=j.account_src_id and not j.account_dst_id is null)'
			]
		];
	}
}
