<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;

/**
 * Равеноство
 * Class Equal
 * @package App\DB\Queries
 */
class Equal extends WhereItem
{
	public function __construct(Field $field, $partner)
	{
		parent::__construct(WhereItem::TYPE_EQUAL, $field, $partner);
	}

	public function get(): string
	{
		$partner = $this->getPartner();
		return sprintf(
			'%s=%s',
			$this->getField()->sqlField(),
			$partner instanceof Field ? $partner->sqlField() : $partner
		);
	}
}