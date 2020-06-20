<?php


namespace App\Entities;

/**
 * Базовый класс для сущностей приложения
 * Class Entity
 * @package App\Entities
 */
abstract class Entity
{
	private $id = 0;

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

	public static function createFromArray(array $fields):?self {
		$entity = new static();
		$entity->setId($fields['id']);
		return $entity;
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
	public function setId(int $id): self
	{
		$this->id = $id;
		return $this;
	}
}