<?php


namespace App\DB\Tables;


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
}