<?php
namespace App\DB\Queries;

use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;

class NotIsNullTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		$where = new NotIsNull($journal->getField('id'));
		$this->assertEquals(WhereItem::TYPE_NOT_IS_NULL, $where->getType());
	}

	/**
	 * @throws FieldUndefinedException
	 */
	public function testGet()
	{
		$journal = new JournalTable();
		$where = new NotIsNull($journal->getField('id'));
		$this->assertEquals('not j.id is null', $where->get());
	}
}
