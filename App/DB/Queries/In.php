<?php


namespace App\DB\Queries;


use App\DB\Fields\Field;
use App\Exception\QueryInEmptyException;

/**
 * Вхождение в перечисление
 * Class In
 * @package App\DB\Queries
 */
class In extends WhereItem
{
	public function __construct(Field $field, array $variants)
	{
		parent::__construct(WhereItem::TYPE_IN, $field, $variants);
	}

	/**
	 * @return string
	 * @throws QueryInEmptyException в случае пустого массива
	 */
	public function get(): string
	{
		$partner = $this->getPartner();
		if (empty($partner)) {
			throw new QueryInEmptyException();
		}
		return sprintf(
			'%s in(%s)',
			$this->getField()->sqlField(),
			implode(',', $partner)
		);
	}
}