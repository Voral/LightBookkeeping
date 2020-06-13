<?php


namespace App\DB\Queries;

/**
 * Группа условий объединяемая AND
 * Class WhereGroupAnd
 * @package App\DB\Queries
 */
class WhereGroupAnd extends WhereGroup
{
	/**
	 * WhereGroupAnd constructor.
	 * @param Where[] $items
	 */
	public function __construct(array $items = [])
	{
		parent::__construct(WhereGroup::LOGIC_AND, $items);
	}
}