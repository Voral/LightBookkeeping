<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Значение NULL
 * Class IsNull
 * @package App\DB\Queries
 */
class IsNull extends WhereItem
{
	public function __construct(Field $field)
	{
		parent::__construct(WhereItem::TYPE_IS_NULL, $field, '');
	}

	public function get(): string
	{
		return sprintf('%s is null', $this->getField()->sqlField());
	}
}