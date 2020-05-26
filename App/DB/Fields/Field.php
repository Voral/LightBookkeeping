<?php

namespace App\DB\Fields;

/**
 * Базовый класс описания полей
 * Class Field
 * @package App\DB\Fields
 */
class Field
{
	/** @var String имя поля */
	protected $name;

	public function __construct(string $name)
	{
		$this->name = $name;
	}

	/**
	 * @return String
	 */
	public function getName(): String
	{
		return $this->name;
	}

	public function sqlField(string $alias = ''): string
	{
		$result = $this->name;
		if ($alias !== ''){
			$result .= (' '.$alias);
		}
 		return $result;
	}
}