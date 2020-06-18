<?php

namespace App\DB\Queries;

use App\DB\Fields\TableField;
use App\DB\Tables\Table;
use App\Exception\QueryUpdateEmptyException;

class UpdateQuery extends WhereQuery
{
	/** @var Set[] */
	protected $set;

	/**
	 * UpdateQuery constructor.
	 * @param Table $table
	 * @param Set[] $set
	 * @param Where|null $where
	 */
	public function __construct(Table $table, array $set, Where $where = null)
	{
		parent::__construct($table);
		$this->setWhere($where);
		$this->set = $set;
	}

	/**
	 * Установка выражения для установки значений
	 * @param Set[] $set
	 * @return self
	 */
	public function setSet(array $set): self
	{
		$this->set = $set;
		return $this;
	}

	/**
	 * Добавляет выражение в список
	 * @param Set $set
	 * @return $this
	 */
	public function addSet(Set $set): self
	{
		$this->set[] = $set;
		return $this;
	}

	/**
	 * @return string
	 * @throws QueryUpdateEmptyException
	 */
	public function get(): string
	{
		TableField::setShowTableAlias(false);
		$sql = [sprintf('update %s', $this->table->getName())];
		$this->generateSet($sql);
		$this->generateWhere($sql);
		TableField::setShowTableAlias(true);
		return implode(' ', $sql);
	}

	/**
	 * Генерируем часть set запроса на оновление
	 * @param array $sql
	 * @throws QueryUpdateEmptyException
	 */
	private function generateSet(array &$sql): void
	{
		if (count($this->set) === 0) {
			throw new QueryUpdateEmptyException();
		}
		$sql[] = sprintf(
			'set %s',
			implode(',', array_map([$this, 'prepareSet'], $this->set))
		);
	}

	/**
	 * Приводит set к строке
	 * @param Set $set
	 * @return string
	 */
	private function prepareSet(Set $set): string
	{
		return $set->get();
	}
}