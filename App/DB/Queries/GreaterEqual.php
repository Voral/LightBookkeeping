<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Больше или равно
 * Class GreaterEqual
 * @package App\DB\Queries
 */
class GreaterEqual extends WhereItem
{
	public function __construct(Field $field, $partner)
	{
		parent::__construct(WhereItem::TYPE_GREATER_EQUAL, $field, $partner);
	}

	public function get(): string
	{
		$partner = $this->getPartner();
		return sprintf(
			'%s>=%s',
			$this->getField()->sqlField(),
			$partner instanceof Field ? $partner->sqlField() : $partner
		);
	}
}