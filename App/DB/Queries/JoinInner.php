<?php

namespace App\DB\Queries;

use App\DB\Tables\Table;

/**
 * Формирование Inner Join части выражения
 * Class JoinInner
 * @package App\DB\Queries
 */
class JoinInner extends Join
{
	public function __construct(Table $table, Where $where)
	{
		parent::__construct($table, $where, Join::TYPE_INNER);
	}
}