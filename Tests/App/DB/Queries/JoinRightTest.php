<?php

namespace App\DB\Queries;

use App\DB\Tables\AccountTable;
use App\DB\Tables\JournalTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;

class JoinRightTest extends TestCase
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
				new JoinRight($journal, new Equal($accFieldId, $jrnSrcId)),
				'right join journal j on a.id=j.account_src_id'
			],
			'doubleExpresion' => [
				new JoinRight($journal, new WhereGroupAnd([
					new Equal($accFieldId, $jrnSrcId),
					new NotIsNull($jrnDstId)
				])),
				'right join journal j on (a.id=j.account_src_id and not j.account_dst_id is null)'
			]
		];
	}
}
