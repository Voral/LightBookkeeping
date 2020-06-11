<?php


namespace App\DB\Queries;

/**
 * Общий класс для построения выражений которые будут использоваться в
 * where и join
 * Class Where
 * @package App\DB\Queries
 */
abstract class Where
{
	public function get():string {
		return '';
	}
}