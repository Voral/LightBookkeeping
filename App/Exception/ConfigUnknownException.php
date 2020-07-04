<?php


namespace App\Exception;

/**
 * Запрошен незаданный ключ конфига
 * Class ConfigUnknownException
 * @package App\Exception
 */
class ConfigUnknownException extends AppException
{
	/** @var string Запрошенный путь параметра */
	private $path;

	/**
	 * FieldException constructor.
	 * @param string $path Запрошенный путь параметра
	 */
	public function __construct(string $path)
	{

		parent::__construct(
			sprintf('Unknown config parameter path %s',$path),
			AppException::CONFIG_UNKNOWN_KEY
		);
		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function getPath(): string
	{
		return $this->path;
	}
}