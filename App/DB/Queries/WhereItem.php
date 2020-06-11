<?php

namespace App\DB\Queries;

use App\DB\Fields\Field;

/**
 * Отдельное Выражение для where
 * Class WhereItem
 * @package App\DB\Queries
 */
class WhereItem extends Where
{
	public const TYPE_EQUAL = 0;
	public const TYPE_EQUAL_NOT = 1;
	public const TYPE_GREATER = 2;
	public const TYPE_GREATER_EQUAL = 3;
	public const TYPE_LESS = 4;
	public const TYPE_LESS_EQUAL = 5;
	public const TYPE_IN = 6;
	public const TYPE_IS_NULL = 7;
	public const TYPE_NOT_IS_NULL = 8;
	public const TYPE_LIKE = 9;
	public const TYPE_START_WITH = 10;
	public const TYPE_END_WITH = 11;

	/** @var int тип сравнения*/
	private $type;
	/** @var Field поле */
	private $field;
	/** @var string | Field | array поле для сравнения или строка*/
	private $partner;

	/**
	 * @return int
	 */
	public function getType(): int
	{
		return $this->type;
	}

	/**
	 * @return Field
	 */
	public function getField(): Field
	{
		return $this->field;
	}

	/**
	 * @return Field|string|array
	 */
	public function getPartner()
	{
		return $this->partner;
	}

	/**
	 * WhereItem constructor.
	 * @param int $type
	 * @param Field $field
	 * @param Field | string | [] $partner
	 */
	public function __construct(int $type, Field $field, $partner)
	{
		$this->type = $type;
		$this->field = $field;
		$this->partner = $partner;
	}
}