<?php

namespace App\DB\Queries;

use App\DB\Tables\Table;

/**
 * Формирование Left Join части выражения
 * Class JoinLeft
 * @package App\DB\Queries
 */

class JoinLeft extends Join
{
	public function __construct(Table $table, Where $where)
	{
		parent::__construct($table, $where, Join::TYPE_LEFT);
	}
}