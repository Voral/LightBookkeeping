<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Начинается с подстроки
 * Class StartWith
 * @package App\DB\Queries
 */
class StartsWith extends WhereItem
{
	public function __construct(Field $field, string $partner)
	{
		parent::__construct(WhereItem::TYPE_START_WITH, $field, $partner);
	}

	public function get(): string
	{
		return sprintf('%s like \'%s%%\'', $this->getField()->sqlField(), $this->getPartner());
	}
}