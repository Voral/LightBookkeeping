<?php
namespace App\DB\Queries;

use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;

class StarWithTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		$where = new StartsWith($journal->getField('id'), 'test');
		$this->assertEquals(WhereItem::TYPE_START_WITH, $where->getType());
	}

	/**
	 * @throws FieldUndefinedException
	 */
	public function testGet()
	{
		$journal = new JournalTable();
		$where = new StartsWith($journal->getField('id'), 'test');
		$this->assertEquals('j.id like \'test%\'', $where->get());
	}
}
