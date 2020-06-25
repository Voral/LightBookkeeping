<?php

namespace App\DB\Queries;

use App\DB\Fields\Field;
use App\DB\Fields\TableField;
use App\DB\Tables\Table;
use App\Exception\FieldUndefinedException;

class SelectQuery extends WhereQuery
{
	/** @var TableField[] */
	private $select = [];
	/** @var Join[] */
	private $join = [];
	private $tableRegistry = [];
	/** @var TableField[] */
	private $order = [];
	/** @var TableField[] */
	private $group = [];
	private $offset = 0;
	private $rowCount = 0;

	private $groupExists = false;

	/**
	 * Генерация строки SQL запроса
	 * Не реализован having
	 * @return string
	 * @throws FieldUndefinedException
	 */
	public function get(): string
	{
		$this->groupExists = false;
		$sql = [];
		$this
			->generateSelect($sql)
			->generateFrom($sql)
			->generateJoin($sql)
			->generateWhere($sql)
			->generateGroup($sql)
			->generateOrder($sql)
			->generateLimit($sql);

		return implode(' ', $sql);
	}

	/**
	 * Генерация limit части запроса.
	 * @param array $sql массив частей запроса
	 * @return $this
	 */
	private function generateLimit(array &$sql): self
	{
		$params = [];
		if ($this->offset > 0) {
			$params[] = $this->offset;
			if ($this->rowCount <= 0) {
				$this->rowCount = PHP_INT_MAX;
			}
		}
		if ($this->rowCount > 0) {
			$params[] = $this->rowCount;
		}
		if (count($params) > 0) {
			$sql[] = sprintf('limit %s', implode(',', $params));
		}
		return $this;
	}

	/**
	 * Генерация group by части запроса.
	 * Устанавливет флаг наличия группировки в случае ее наличия.
	 * Флаг используется для зависимых частей, например having
	 * @param array $sql массив частей запроса
	 * @return $this
	 */
	private function generateGroup(array &$sql): self
	{
		if (!empty($this->group)) {
			$str = implode(',', array_map([$this, 'prepareField'], $this->group));
			if ($str !== '') {
				$sql[] = sprintf('group by %s', $str);
				$this->groupExists = true;
			}
		}
		return $this;
	}

	/**
	 * Генерация order by части запроса.
	 * @param array $sql массив частей запроса
	 * @return $this
	 */
	private function generateOrder(array &$sql): self
	{
		if (!empty($this->order)) {
			$str = implode(',', array_map([$this, 'prepareField'], $this->order));
			if ($str !== '') {
				$sql[] = sprintf('order by %s', $str);
			}
		}
		return $this;
	}

	private function generateFrom(array &$sql): self
	{
		$sql[] = sprintf('from %s %s', $this->table->getName(), $this->table->getAlias());
		return $this;
	}

	/**
	 * Задает массив полей для выбора
	 * @param Field[] $arSelect
	 * @return $this
	 */
	public function setSelect(array $arSelect): self
	{
		$this->select = $arSelect;
		return $this;
	}

	/**
	 * Добавляет поле в выборку
	 * @param Field $name
	 * @param string $alias
	 * @return $this
	 */
	public function addSelect(Field $name, string $alias = ''): self
	{
		if ($alias === '') {
			$this->select[] = $name;
		} else {
			$this->select[$alias] = $name;
		}
		return $this;
	}

	/**
	 * Генерирует select часть запроса
	 * @param string[] $sql
	 * @return $this
	 * @throws FieldUndefinedException
	 */
	private function generateSelect(&$sql): self
	{
		$arSelect = empty($this->select)
			? [$this->table->getField('id')]
			: $this->select;
		array_walk($arSelect, [$this, 'prepareSelect']);
		$sql[] = sprintf('select %s', implode(',', array_unique(array_values($arSelect))));
		return $this;
	}

	/**
	 * Преобразовывает поле в стоку для подстановки в выражение
	 * @param TableField $field
	 * @return string
	 */
	private function prepareField(TableField $field): string
	{
		return $field->sqlField();
	}

	/**
	 * Устаналвиваем список Join
	 * @param Join[] $join
	 * @return self
	 */
	public function setJoin(array $join): self
	{
		$this->join = $join;
		$this->tableRegistry = [get_class($this->table) => 0];
		foreach ($this->join as $join) {
			$this->registerTable($join->getTable());
		}
		return $this;
	}

	/**
	 * Возвращает текстовое представление имени поля с алиасом
	 * @param Field $field
	 * @param string | int $key
	 * //* @return string
	 */
	private function prepareSelect(Field &$field, $key): void
	{
		$alias = is_numeric($key) ? '' : $key;
		$field = $field->sqlField($alias);
	}

	/**
	 * Регистрация таблиц участвующих в запросе и установка
	 * суффиксов алиасов для обеспечения уникальности
	 * @param Table $table
	 */
	private function registerTable(Table $table): void
	{
		$class = get_class($table);
		if (array_key_exists($class, $this->tableRegistry)) {
			$table->setAliasSuffix(++$this->tableRegistry[$class]);
		} else {
			$this->tableRegistry[$class] = 0;
		}
	}

	/**
	 * Добавление join в список
	 * @param Join $join
	 * @return $this
	 */
	public function addJoin(Join $join): self
	{
		if (empty($this->tableRegistry)) {
			$this->tableRegistry = [get_class($this->table) => 0];
			$this->join = [];
		}
		$this->registerTable($join->getTable());
		$this->join[] = $join;
		return $this;
	}

	/**
	 * Генерирует строку join
	 * @param array $sql
	 * @return self
	 */
	private function generateJoin(array &$sql): self
	{
		$str = implode(' ', array_map([$this, 'prepareJoin'], $this->join));
		if ($str !== '') {
			$sql[] = $str;
		}
		return $this;
	}

	/**
	 * Обработка массива join для построения строки
	 * @param Join $item
	 * @return string
	 */
	private function prepareJoin(Join $item): string
	{
		return $item->get();
	}

	/**
	 * Устанавливает массив для сортировки
	 * @param TableField[] $order
	 * @return self
	 */
	public function setOrder(array $order): self
	{
		$this->order = $order;
		return $this;
	}

	/**
	 * Устанавливает массив для группировки
	 * @param TableField[] $group
	 * @return self
	 */
	public function setGroup(array $group): self
	{
		$this->group = $group;
		return $this;
	}

	/**
	 * Устанавливает смещение для выборки
	 * @param int $offset
	 * @return self
	 */
	public function setOffset(int $offset): self
	{
		$this->offset = $offset;
		return $this;
	}

	/**
	 * Устанавливает количество запрашиваемых строк
	 * @param int $rowCount
	 * @return self
	 */
	public function setRowCount(int $rowCount): self
	{
		$this->rowCount = $rowCount;
		return $this;
	}


}