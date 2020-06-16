<?php


namespace App\DB\Queries;


use App\DB\Tables\Table;

/***
 * Абстрактный класс для формирования Join части выражения
 * Class Join
 * @package App\DB\Queries
 */
abstract class Join
{
	const TYPE_INNER = 'inner';
	const TYPE_LEFT = 'left';
	const TYPE_RIGHT = 'right';
	/** @var Table */
	private $table;
	/** @var Where */
	private $where;

	private $type;

	public function __construct(Table $table, Where $where, string $type)
	{
		$this->table = $table;
		$this->where = $where;
		$this->type = $type;
	}

	public function get(): string
	{
		$result = '';
		if ($this->where) {
			$sqlWhere = $this->where->get();
			if ($sqlWhere !== '') {
				$result = sprintf(
					'%s join %s %s on %s',
					$this->type,
					$this->table->getName(),
					$this->table->getAlias(),
					$sqlWhere
				);
			}
		}
		return $result;
	}

	/**
	 * @return Table
	 */
	public function getTable(): Table
	{
		return $this->table;
	}
}