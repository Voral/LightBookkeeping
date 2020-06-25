<?php


namespace App\DB\Queries;

use App\Exception\QueryUnknownLogicException;

/**
 * Базовый класс для запросов с условиями
 * Class WhereQuery
 * @package App\DB\Queries
 */
abstract class WhereQuery extends Query
{
	/** @var Where */
	private $where;

	/**
	 * Генерация условий запроса
	 * @param array $sql
	 * @param static
	 * @return static
	 */
	protected function generateWhere(array &$sql)
	{
		if ($this->where) {
			$sqlWhere = $this->where->get();
			if ($sqlWhere !== '') {
				$sql[] = sprintf('where %s', $sqlWhere);
			}
		}
		return $this;
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
}