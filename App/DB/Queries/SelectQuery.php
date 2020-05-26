<?php

namespace App\DB\Queries;

use App\Exception\FieldUndefinedException;

class SelectQuery extends Query
{
	private $select = [];

	public function get(): string
	{
		$sql = sprintf(
			'select %s from %s %s',
			$this->getSelect(),
			$this->table->getName(),
			$this->aliasRegistry[spl_object_id($this->table)]
		);
		return $sql;
	}

	public function setSelect(array $arSelect): self
	{
		$this->select = $arSelect;
		return $this;
	}

	public function addSelect(string $name, string $alias = ''): self
	{
		if ($alias === '') {
			$this->select[] = $name;
		} else {
			$this->select[$alias] = $name;
		}
		return $this;
	}

	private function getSelect(): string
	{
		$arSelect = empty($this->select) ? ['id'] : $this->select;
		array_walk($arSelect, [$this, 'generateSelect']);
		return implode(',', array_unique(array_values($arSelect)));
	}

	/**
	 * Преобразовывает имя поля в представление с алиасами
	 * @param string $name
	 * @param string $key
	 * @throws FieldUndefinedException Выбрасывается если запрошено не существующее поле
	 */
	public function generateSelect(string &$name, string $key): void
	{
		$alias = is_numeric($key) ? '' : $key;
		$name = $this->table->getField($name)->sqlField($alias);
	}

}