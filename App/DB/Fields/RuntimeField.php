<?php

namespace App\DB\Fields;

/**
 * Поле для добавления функций в запрос.
 * Class RuntimeField
 * @package App\DB\Fields
 */
class RuntimeField extends Field
{
	private $expression;
	private $parts;

	public function __construct(string $name, string $expression, array $parts)
	{
		parent::__construct($name);
		$this->expression = $expression;
		$this->parts = $parts;
	}

	public function sqlField(string $alias = ''): string
	{
		return sprintf($this->expression, ...array_map([$this, 'prepareParts'], $this->parts))
			.' '.$this->name;
	}

	/**
	 * @param $field
	 * @return string
	 */
	private function prepareParts(Field $field)
	{
		return $field->sqlField();
	}
}