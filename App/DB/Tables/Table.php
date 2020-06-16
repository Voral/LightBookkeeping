<?php

namespace App\DB\Tables;

use App\DB\Fields\Field;
use App\Exception\FieldUndefinedException;

abstract class Table
{
	protected $name = '';
	protected $alias = '';
	/** @var array Field */
	protected $fields = [];

	private $aliasSuffix = '';

	/**
	 * @return string
	 */
	public function getAlias(): string
	{
		return $this->alias.$this->aliasSuffix;
	}

	/**
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * @return array
	 */
	public function getFields(): array
	{
		return $this->fields;
	}

	/**
	 * @param string $name
	 * @return Field
	 * @throws FieldUndefinedException
	 */
	public function getField(string $name): Field
	{
		if (array_key_exists($name, $this->fields)) {
			return $this->fields[$name];
		}
		throw new FieldUndefinedException($this->name, $name);
	}

	/**
	 * @param int $aliasSuffix
	 * @return self
	 */
	public function setAliasSuffix(int $aliasSuffix): self
	{
		$this->aliasSuffix = $aliasSuffix <= 0 ? '' : $aliasSuffix;
		return $this;
	}
}