<?php


namespace App\DB\Tables;


use App\DB\Fields\Field;
use App\Exception\FieldException;

abstract class Table
{
	protected $name = '';
	protected $alias = '';
	/** @var array Field */
	protected $fields = [];

	/**
	 * @return string
	 */
	public function getAlias(): string
	{
		return $this->alias;
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
	 * @throws FieldException
	 */
	public function getField(string $name): Field
	{
		if (array_key_exists($name, $this->fields)) {
			return $this->fields[$name];
		}
		throw new FieldException(sprintf(
			'Field %s is not defined in table %s',
			$this->name,
			$name
		));
	}
}