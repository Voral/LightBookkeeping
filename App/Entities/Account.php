<?php


namespace App\Entities;

use App\DB\Tables\AccountTable;

/**
 * Счет
 * Class Account
 * @package App\Entity
 */
class Account extends Entity
{
	private $marginLeft = 0;
	private $marginRight = 0;
	private $parentId = 0;
	private $name = '';
	private $shortName = '';
	private $groupId = 0;
	private $typeId = 0;
	private $defaultPartner = 0;

	public function __construct()
	{
		/** @var callable[] proxySetters */
		$this->proxySetters = [
			AccountTable::FIELD_NAME => [$this,'setName'],
			AccountTable::FIELD_SHORT_NAME => [$this,'setShortName'],
			AccountTable::FIELD_DEFAULT_PARTNER => [$this,'setDefaultPartner'],
			AccountTable::FIELD_LEFT_MARGIN => [$this,'setMarginLeft'],
			AccountTable::FIELD_RIGHT_MARGIN => [$this,'setMarginRight'],
			AccountTable::FIELD_PARENT_ID => [$this,'setParentId'],
			AccountTable::FIELD_GROUP_ID => [$this,'setGroupId'],
			AccountTable::FIELD_TYPE_ID => [$this,'setTypeId'],
		];
	}

	/**
	 * @param int $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setDefaultPartner(int $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_DEFAULT_PARTNER, $this->defaultPartner);
		}
		$this->defaultPartner = $value;
		return $this;
	}

	/**
	 * @param int $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setTypeId(int $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_TYPE_ID, $this->typeId);
		}
		$this->typeId = $value;
		return $this;
	}

	/**
	 * @param int $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setGroupId(int $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_GROUP_ID, $this->groupId);
		}
		$this->groupId = $value;
		return $this;
	}

	/**
	 * @param string $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setShortName(string $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_SHORT_NAME, $this->shortName);
		}
		$this->shortName = $value;
		return $this;
	}

	/**
	 * @param string $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setName(string $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_NAME, $this->name);
		}
		$this->name = $value;
		return $this;
	}

	/**
	 * @param int $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setMarginLeft(int $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_LEFT_MARGIN, $this->marginLeft);
		}
		$this->marginLeft = $value;
		return $this;
	}

	/**
	 * @param int $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setMarginRight(int $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_RIGHT_MARGIN, $this->marginRight);
		}
		$this->marginRight = $value;
		return $this;
	}

	/**
	 * @param int $value
	 * @param bool $mark помечать поле модифицированным
	 * @return $this
	 */
	public function setParentId(int $value, bool $mark = true): self
	{
		if ($mark) {
			$this->addModified(AccountTable::FIELD_PARENT_ID, $this->parentId);
		}
		$this->parentId = $value;
		return $this;
	}

	/**
	 * Возвращет идентификатор счета корреспондента по умолчанию
	 * @return int
	 */
	public function getDefaultPartner(): int
	{
		return $this->defaultPartner;
	}

	/**
	 * Возвращает ИД группы счета
	 * @return int
	 */
	public function getGroupId(): int
	{
		return $this->groupId;
	}

	/**
	 * Возвращает левую границу счета
	 * @return int
	 */
	public function getMarginLeft(): int
	{
		return $this->marginLeft;
	}

	/**
	 * Возвращает правую границу счета
	 * @return int
	 */
	public function getMarginRight(): int
	{
		return $this->marginRight;
	}

	/**
	 * Возвращает наименование счета
	 * @return string
	 */
	public function getName(): string
	{
		return $this->name;
	}

	/**
	 * Возвращает короткое наименование счета
	 * @return string
	 */
	public function getShortName(): string
	{
		return $this->shortName;
	}

	/**
	 * Возвращает ИД родительского счета
	 * @return int
	 */
	public function getParentId(): int
	{
		return $this->parentId;
	}

	/**
	 * Врзвращает ИД типа счета
	 * @return int
	 */
	public function getTypeId(): int
	{
		return $this->typeId;
	}

}