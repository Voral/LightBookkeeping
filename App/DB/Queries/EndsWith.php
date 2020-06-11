<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Заканчивается подстрокой
 * Class EndsWidth
 * @package App\DB\Queries
 */
class EndsWith extends WhereItem
{
	public function __construct(Field $field, string $partner)
	{
		parent::__construct(WhereItem::TYPE_END_WITH, $field, $partner);
	}

	public function get(): string
	{
		return sprintf('%s like \'%%%s\'', $this->getField()->sqlField(), $this->getPartner());
	}
}