<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Меньше или равно
 * Class LessEqual
 * @package App\DB\Queries
 */
class LessEqual extends WhereItem
{
	public function __construct(Field $field, $partner)
	{
		parent::__construct(WhereItem::TYPE_LESS_EQUAL, $field, $partner);
	}

	public function get(): string
	{
		$partner = $this->getPartner();
		return sprintf(
			'%s<=%s',
			$this->getField()->sqlField(),
			$partner instanceof Field ? $partner->sqlField() : $partner
		);
	}
}