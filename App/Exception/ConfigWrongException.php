<?php


namespace App\Exception;

/**
 * Ошибка конфигурации
 * Class ConfigWrongException
 * @package App\Exception
 */
class ConfigWrongException extends AppException
{
	/** @var string Класс поля */
	private $sectionName;

	/**
	 * FieldException constructor.
	 * @param string $sectionName
	 */
	public function __construct(string $sectionName)
	{

		parent::__construct(
			sprintf('Invalid config in section %s',$sectionName),
			AppException::CONFIG_WRONG
		);
		$this->sectionName = $sectionName;
	}

	/**
	 * @return string
	 */
	public function getSectionName(): string
	{
		return $this->sectionName;
	}
}