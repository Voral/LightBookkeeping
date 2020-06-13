<?php

namespace App\DB\Queries;

use App\DB\Tables\AccountTable;
use App\Exception\FieldUndefinedException;
use PHPUnit\Framework\TestCase;

class WhereGroupOrTest extends TestCase
{

	/**
	 * @param string $where
	 * @param string $expected
	 * @dataProvider getDataProvider
	 */
	public function testGet(string $where, string $expected)
	{
		$this->assertEquals($expected, $where);
	}

	/**
	 * - Проверяемое поле должно быть с алиасом таблицы
	 * - Если единственное условие - выражение без скобок
	 * - Если условий несколько: объедиение через and и окружает скобками
	 * - setItems - замещает список выражений
	 * - addItems - добавляет выражение в список
	 * - при пустом списке возвращается пустая строка
	 * - выражением может быть и вложееная группа
	 * @return array[]
	 * @throws FieldUndefinedException
	 */
	public function getDataProvider()
	{
		$account = new AccountTable();
		$fieldId = $account->getField('id');
		$fieldName = $account->getField('name');
		$where1 = new WhereGroupOr([
			new Equal($fieldId, 2),
			new Like($fieldName,'test')
		]);
		$where2 = new WhereGroupOr([new Equal($fieldId, 1)]);
		return [
			'single' => [
				$where2->get(),
				'a.id=1'
			],
			'double' => [
				$where1->get(),
				'(a.id=2 or a.name like \'%test%\')'
			],
			'replace' => [
				$where1->setItems([new NotEqual($fieldId, 10)])->get(),
				'a.id<>10'
			],
			'add' => [
				$where1->addItem(new NotIsNull($fieldName))->get(),
				'(a.id<>10 or not a.name is null)'
			],
			'multiLevel' => [
				$where2->addItem($where1)->get(),
				'(a.id=1 or (a.id<>10 or not a.name is null))'
			],
			'empty' => [
				$where1->setItems([])->get(),
				''
			]
		];
	}
}
