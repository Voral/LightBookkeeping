<?php

namespace App\DB\Entities;


use App\DB\Tables\AccountTable;
use App\Entities\Account;
use App\Exception\AppException;
use App\Exception\EntityFieldUnknownException;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
	private static $data = [
		AccountTable::FIELD_ID => '1',
		AccountTable::FIELD_LEFT_MARGIN => '10',
		AccountTable::FIELD_RIGHT_MARGIN => '12',
		AccountTable::FIELD_PARENT_ID => '2',
		AccountTable::FIELD_NAME => 'Test account',
		AccountTable::FIELD_SHORT_NAME => 'Test',
		AccountTable::FIELD_GROUP_ID => '2',
		AccountTable::FIELD_TYPE_ID => '3',
		AccountTable::FIELD_DEFAULT_PARTNER => '5',
	];


	/**
	 * Класс является основным для проекта. Здесь же тестируем и методы абстрактного класса
	 * - при загрузке из массива должны быть задействованы все отвечающие за соответсвующие
	 *   поля сеттеры
	 * - неизвестные поля (те для которых не задан сеттер) игнорируются
	 * - при загрузке из массива свойства не помечаются как модифицированные
	 * - геттеры возвращают загруженные значения
	 */
	public function testFromDB()
	{
		$account = Account::createFromArray(self::$data);
		$this->assertSame((int)self::$data['id'], $account->getId());
		$this->assertSame((int)self::$data['left_margin'], $account->getMarginLeft());
		$this->assertSame((int)self::$data['right_margin'], $account->getMarginRight());
		$this->assertSame((int)self::$data['parent_id'], $account->getParentId());
		$this->assertSame((int)self::$data['group_id'], $account->getGroupId());
		$this->assertSame((int)self::$data['type_id'], $account->getTypeId());
		$this->assertSame((int)self::$data['default_partner'], $account->getDefaultPartner());
		$this->assertSame(self::$data['name'], $account->getName());
		$this->assertSame(self::$data['short_name'], $account->getShortName());
		$this->assertFalse($account->isModified());
	}

	/**
	 * @param string $fieldName
	 * @param int | string $newValue
	 * @dataProvider modifiedDataProvider
	 * @throws EntityFieldUnknownException
	 */
	public function testModified(string $fieldName, $newValue)
	{
		$arFields = array_keys(self::$data);
		$account = Account::createFromArray(self::$data);
		$account->setField($fieldName, $newValue);
		foreach ($arFields as $field) {
			$this->assertEquals(
				$field === $fieldName,
				$account->isFieldModified($field)
			);
		}
		$this->assertTrue($account->isModified());
	}

	public function modifiedDataProvider(): array
	{
		return [
			AccountTable::FIELD_LEFT_MARGIN => [AccountTable::FIELD_LEFT_MARGIN, 2000],
			AccountTable::FIELD_RIGHT_MARGIN => [AccountTable::FIELD_RIGHT_MARGIN, 3000],
			AccountTable::FIELD_PARENT_ID => [AccountTable::FIELD_PARENT_ID, 4000],
			AccountTable::FIELD_NAME => [AccountTable::FIELD_NAME, 'New'],
			AccountTable::FIELD_SHORT_NAME => [AccountTable::FIELD_SHORT_NAME, 'Modify'],
			AccountTable::FIELD_GROUP_ID => [AccountTable::FIELD_GROUP_ID, 5000],
			AccountTable::FIELD_TYPE_ID => [AccountTable::FIELD_TYPE_ID, 6000],
			AccountTable::FIELD_DEFAULT_PARTNER => [AccountTable::FIELD_DEFAULT_PARTNER, 7000]
		];
	}

	/**
	 * При попытке установить значение для неизвестного поля выкидывается исключение
	 * @throws EntityFieldUnknownException
	 */
	public function testException(): void
	{
		$account = new Account();
		$this->expectExceptionCode(AppException::ENTITY_FIELD_UNKNOWN);
		$this->expectExceptionMessage('Attempt to set a value for a unknown field unknown-field (App\Entities\Account)');
		$account->setField('unknown-field', 10);
	}

}
