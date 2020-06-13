<?php


namespace App\DB\Queries;

/**
 * Группа условий объединяемая OR
 * Class WhereGroupOr
 * @package App\DB\Queries
 */
class WhereGroupOr extends WhereGroup
{
	/**
	 * WhereGroupAnd constructor.
	 * @param Where[] $items
	 */
	public function __construct(array $items = [])
	{
		parent::__construct(WhereGroup::LOGIC_OR, $items);
	}
}