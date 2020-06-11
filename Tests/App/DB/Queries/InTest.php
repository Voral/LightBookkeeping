<?php
namespace App\DB\Queries;

use App\Exception\AppException;
use App\Exception\FieldUndefinedException;
use App\Exception\QueryInEmptyException;
use PHPUnit\Framework\TestCase;
use App\DB\Tables\JournalTable;
class InTest extends TestCase
{
	/**
	 * Должен устанавливаться заданный тип
	 * @throws FieldUndefinedException
	 */
	public function testConstruct() {
		$journal = new JournalTable();
		$where = new In($journal->getField('id'), [1]);
		$this->assertEquals(WhereItem::TYPE_IN, $where->getType());
	}
	/**
	 * Исключение при пустом массиве
	 * @throws QueryInEmptyException
	 * @throws FieldUndefinedException
	 */
	public function testEmptyArray() {
		$journal = new JournalTable();
		$where = new In($journal->getField('id'), []);
		$this->expectException(QueryInEmptyException::class);
		$this->expectExceptionCode(AppException::QUERIES_EMPTY_ARRAY);
		$where->get();
	}

	/**
	 * @param In $where
	 * @param string $expected
	 * @dataProvider getDataProvider
	 * @throws QueryInEmptyException
	 */
	public function testGet(In $where, $expected)
	{
		$this->assertEquals($expected, $where->get());
	}

	/**
	 * - Проверяемое поле должно быть салиасом таблицы
	 * - Выражение проверки знак равенства
	 * - Если партнер инстас типа Field то название поля с алиасом таблицы
	 * - если строка подставляется без изменений
	 * @return array[]
	 * @throws FieldUndefinedException
	 */
	public function getDataProvider()
	{
		$journal = new JournalTable();
		return [
			'single' => [
				new In($journal->getField('id'), [1,2]),
				'j.id in(1,2)'
			],
			'once' => [
				new In($journal->getField('id'), [1]),
				'j.id in(1)'
			]
		];
	}
}
