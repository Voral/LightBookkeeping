<?php


namespace App\DB\Queries;

use App\Exception\QueryUnknownLogicException;

/**
 * Группа условий связанная логикой
 * Class WhereGroup
 * @package App\DB\Queries
 */
abstract class WhereGroup extends Where
{
	const LOGIC_AND = 'and';
	const LOGIC_OR = 'or';
	/** @var string логика объединения условий */
	private $logic = self::LOGIC_AND;
	/** @var Where[] массив условий */
	private $items = [];

	public function __construct(string $logic, array $items)
	{
		$this->logic = $logic;
		$this->items = $items;
	}

	/**
	 * Установка списка условий группы.
	 * Все ранее добавленные условия удалаяются
	 * @param Where[] $items
	 * @return self
	 */
	public function setItems(array $items): self
	{
		$this->items = $items;
		return $this;
	}

	/**
	 * Добавляем условие в группу
	 * @param Where $item
	 * @return $this
	 */
	public function addItem(Where $item): self
	{
		$this->items[] = $item;
		return $this;
	}

	public function get(): string
	{
		$return = '';
		$arReady = [];
		foreach ($this->items as $item) {
			$itemStr = $item->get();
			if ($itemStr !== '') {
				$arReady[] = $itemStr;
			}
		}
		$size = count($arReady);
		if ($size === 1) {
			$return = $arReady[0];
		} elseif ($size > 1) {
			$return = '(' . implode(
					sprintf(' %s ', $this->logic),
					$arReady
				) . ')';
		}
		return $return;
	}

	/**
	 * @return string
	 */
	public function getLogic(): string
	{
		return $this->logic;
	}

	/**
	 * @param Where[] $where
	 * @param string $logic
	 * @return WhereGroupAnd|WhereGroupOr
	 * @throws QueryUnknownLogicException
	 */
	public static function fabric($where,$logic = WhereGroup::LOGIC_AND) {
		if ($logic === WhereGroup::LOGIC_AND) {
			return new WhereGroupAnd($where);
		}
		if ($logic === WhereGroup::LOGIC_OR) {
			return new WhereGroupOr($where);
		}
		throw new QueryUnknownLogicException($logic);
	}
}