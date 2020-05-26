<?php


namespace App\DB\Fields;

/**
 * Поле типа деньги. Должно храниться только два знака после запятой
 * Class MoneyField
 * @package App\DB\Fields
 */
class MoneyField extends TableField
{
	/**
	 * Обработка значения при установке значения свойства
	 * @param $value
	 * @return float
	 */
	public function prepareValue($value): float
	{
		return round(parent::prepareValue($value), 2);
	}
}