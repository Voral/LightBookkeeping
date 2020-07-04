<?php


namespace App\DB\Tables;


use App\DB\Fields\IntegerField;
use App\DB\Fields\StringField;

class AccountTable extends Table
{
	public const FIELD_ID = 'id';
	public const FIELD_LEFT_MARGIN = 'left_margin';
	public const FIELD_RIGHT_MARGIN = 'right_margin';
	public const FIELD_PARENT_ID = 'parent_id';
	public const FIELD_NAME = 'name';
	public const FIELD_SHORT_NAME = 'short_name';
	public const FIELD_GROUP_ID = 'group_id';
	public const FIELD_TYPE_ID = 'type_id';
	public const FIELD_DEFAULT_PARTNER = 'default_partner';

	public function __construct()
	{
		$this->name = 'account';
		$this->alias = 'a';
		$this->fields = [
			self::FIELD_ID => new IntegerField($this, self::FIELD_ID),
			self::FIELD_LEFT_MARGIN => new IntegerField($this, self::FIELD_LEFT_MARGIN),
			self::FIELD_RIGHT_MARGIN => new IntegerField($this, self::FIELD_RIGHT_MARGIN),
			self::FIELD_PARENT_ID => new IntegerField($this, self::FIELD_PARENT_ID),
			self::FIELD_NAME => new StringField($this, self::FIELD_NAME),
			self::FIELD_SHORT_NAME => new StringField($this, self::FIELD_SHORT_NAME),
			self::FIELD_GROUP_ID => new IntegerField($this, self::FIELD_GROUP_ID),
			self::FIELD_TYPE_ID => new IntegerField($this, self::FIELD_TYPE_ID),
			self::FIELD_DEFAULT_PARTNER => new IntegerField($this, self::FIELD_DEFAULT_PARTNER),
		];
	}
}