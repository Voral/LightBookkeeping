<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Содержит подстроку
 * Class Like
 * @package App\DB\Queries
 */
class Like extends WhereItem
{
	public function __construct(Field $field, string $partner)
	{
		parent::__construct(WhereItem::TYPE_LIKE, $field, $partner);
	}

	public function get(): string
	{
		return sprintf('%s like \'%%%s%%\'', $this->getField()->sqlField(), $this->getPartner());
	}
}