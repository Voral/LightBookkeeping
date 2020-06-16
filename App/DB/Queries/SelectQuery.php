<?php

namespace App\DB\Queries;

use App\DB\Tables\Table;
use App\Exception\FieldUndefinedException;
use App\Exception\QueryUnknownLogicException;

class SelectQuery extends Query
{
	private $select = [];
	/** @var Where */
	private $where;
	/** @var Join[] */
	private $join = [];
	private $tableRegistry = [];

	/**
	 * Генерация строки SQL запроса
	 * @return string
	 */
	public function get(): string
	{
		$sql = [];
		$this->generateSelect($sql);
		$this->generateJoin($sql);
		$this->generateWhere($sql);
		return implode(' ', $sql);
	}

	private function generateSelect(array &$sql): void
	{
		$sql[] = sprintf(
			'select %s from %s %s',
			$this->getSelect(),
			$this->table->getName(),
			$this->table->getAlias()
		);
	}

	/**
	 * Генерация условий запроса
	 * @param array $sql
	 */
	private function generateWhere(array &$sql): void
	{
		if ($this->where) {
			$sqlWhere = $this->where->get();
			if ($sqlWhere !== '') {
				$sql[] = sprintf('where %s', $sqlWhere);
			}
		}
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
		array_walk($arSelect, [$this, 'prepareSelect']);
		return implode(',', array_unique(array_values($arSelect)));
	}

	/**
	 * Преобразовывает имя поля в представление с алиасами
	 * @param string $name
	 * @param string $key
	 * @throws FieldUndefinedException Выбрасывается если запрошено не существующее поле
	 */
	private function prepareSelect(string &$name, string $key): void
	{
		$alias = is_numeric($key) ? '' : $key;
		$name = $this->table->getField($name)->sqlField($alias);
	}

	/**
	 * Устанавливает условие выборки
	 * @param Where $where
	 * @return self
	 */
	public function setWhere(Where $where): self
	{
		$this->where = $where;
		return $this;
	}

	/**
	 * Добавляет условие выборки
	 * @param Where $where
	 * @param string $logic
	 * @return self
	 * @throws QueryUnknownLogicException
	 */
	public function addWhere(Where $where, $logic = WhereGroup::LOGIC_AND): self
	{
		if ($this->where instanceof WhereGroup && $this->where->getLogic() === $logic) {
			$this->where->addItem($where);
		} else {
			$this->where = WhereGroup::fabric([$this->where, $where], $logic);
		}
		return $this;
	}

	/**
	 * Устаналвиваем список Join
	 * @param Join[] $join
	 * @return self
	 */
	public function setJoin(array $join): self
	{
		$this->join = $join;
		$this->tableRegistry = [
			get_class($this->table) => 0
		];
		foreach ($this->join as $join) {
			$this->registerTable($join->getTable());
		}
		return $this;
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
			$this->tableRegistry = [
				get_class($this->table) => 0
			];
			$this->join = [];
		}
		$this->registerTable($join->getTable());
		$this->join[] = $join;
		return $this;
	}

	/**
	 * Генерирует строку join
	 * @param array $sql
	 */
	private function generateJoin(array &$sql): void
	{
		$str = implode(' ', array_map([$this, 'prepareJoin'], $this->join));
		if ($str !== '') {
			$sql[] = $str;
		}
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
}