<?php
namespace App\DB\Queries;

use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;

class IsNullTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		/** @var JournalTable $journal */
		$where = new IsNull($journal->getField('id'));
		$this->assertEquals(WhereItem::TYPE_IS_NULL, $where->getType());
	}

	/**
	 * @throws FieldUndefinedException
	 */
	public function testGet()
	{
		$journal = new JournalTable();
		$where = new IsNull($journal->getField('id'));
		$this->assertEquals('j.id is null', $where->get());
	}
}
