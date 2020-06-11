<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Значение не NULL
 * Class NotIsNull
 * @package App\DB\Queries
 */
class NotIsNull extends WhereItem
{
	public function __construct(Field $field)
	{
		parent::__construct(WhereItem::TYPE_NOT_IS_NULL, $field, '');
	}

	public function get(): string
	{
		return sprintf('not %s is null', $this->getField()->sqlField());
	}
}