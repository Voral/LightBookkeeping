<?php


namespace App\Entities;

use App\Exception\EntityFieldUnknownException;

/**
 * Базовый класс для сущностей приложения
 * Class Entity
 * @package App\Entities
 */
abstract class Entity
{
	private $id = 0;
	/**
	 * Соответсвие полей и сеттеров
	 * @var callable[]
	 */
	protected $proxySetters = [];

	/***
	 * Модифицированные поля.
	 * Ключ - имя поля, значение - старое значение
	 * @var array
	 */
	private $modified = [];

	/**
	 * Загрузка сущности из таблицы
	 * @param int $id
	 * @return static
	 */
	public static function load(int $id): self
	{
		$result = new static();
		$result->setId($id);
		return $result;
	}

	/**
	 * Создает сущность из массива с использованием массива
	 * соответсвия полей и сеттеров
	 * @param array $fields
	 * @return static|null
	 */
	public static function createFromArray(array $fields): ?self
	{
		$entity = new static();
		if (array_key_exists('id', $fields)) {
			$entity->setId($fields['id']);
		}
		foreach ($fields as $code => $value) {
			if (array_key_exists($code, $entity->proxySetters)) {
				$entity->proxySetters[$code]($value, false);
			}
		}
		return $entity;
	}

	/**
	 * Устанавливет значение для поле по его имени
	 * @param $fieldName
	 * @param $value
	 * @param bool $mark
	 * @return static
	 * @throws EntityFieldUnknownException
	 */
	public function setField($fieldName, $value, bool $mark = true)
	{
		if ($fieldName === 'id') {
			$this->setId($value);
		} elseif (array_key_exists($fieldName, $this->proxySetters)) {
			$this->proxySetters[$fieldName]($value, $mark);
		} else {
			throw new EntityFieldUnknownException($fieldName,static::class);
		}
		return $this;
	}

	/**
	 * @return int
	 */
	public function getId(): int
	{
		return $this->id;
	}

	/**
	 * @param int $id
	 * @return self
	 */
	private function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}

	/**
	 * Сохраняем значение поля до модификации.
	 * Сохраняется только то значение, которое было в самом начале
	 * @param string $fieldName
	 * @param mixed $value
	 * @return static
	 */
	protected function addModified(string $fieldName, $value)
	{
		if (!array_key_exists($fieldName, $this->modified)) {
			$this->modified[$fieldName] = $value;
		}
		return $this;
	}

	/**
	 * Показывает была ли сущность модифицирована
	 * @return bool
	 */
	public function isModified(): bool
	{
		return count($this->modified) > 0;
	}

	/**
	 * Показывает было ли поле модифицировано
	 * @param string $fieldName
	 * @return bool
	 */
	public function isFieldModified(string $fieldName): bool
	{
		return array_key_exists($fieldName, $this->modified);
	}

	/**
	 * Метод сохраняет сущность если ИД больше 0 и добавляет если 0
	 * @return bool
	 */
	public function save(): bool
	{
		return true;
	}
}