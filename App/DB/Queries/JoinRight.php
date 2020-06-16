<?php

namespace App\DB\Queries;

use App\DB\Tables\Table;

/**
 * Формирование Right Join части выражения
 * Class JoinRight
 * @package App\DB\Queries
 */
class JoinRight extends Join
{
	public function __construct(Table $table, Where $where)
	{
		parent::__construct($table, $where, Join::TYPE_RIGHT);
	}
}