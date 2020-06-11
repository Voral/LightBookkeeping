<?php
namespace App\DB\Queries;

use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;

class LikeTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		$where = new Like($journal->getField('id'), 'test');
		$this->assertEquals(WhereItem::TYPE_LIKE, $where->getType());
	}

	/**
	 * @throws FieldUndefinedException
	 */
	public function testGet()
	{
		$journal = new JournalTable();
		$where = new Like($journal->getField('id'), 'test');
		$this->assertEquals('j.id like \'%test%\'', $where->get());
	}
}
