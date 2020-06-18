<?php


namespace App\DB\Queries;

use App\DB\Fields\TableField;

/** Выражение установки значения для update запроса */
class Set
{
	/** @var TableField */
	private $field;
	/** @var mixed */
	private $value;

	public function __construct(TableField $field, $value)
	{
		$this->field = $field;
		$this->value = $value;
	}

	public function get(): string
	{
		return sprintf('%s=%s', $this->field->getName(), $this->field->toDB($this->value));
	}
}