<?php


namespace App;

use App\Exception\ConfigUnknownException;
use App\Exception\ConfigWrongException;

/**
 * Настройки приложения
 * Class Config
 * @package App
 */
class Config
{
	public const DATABASE = 'Database';
	public const DATABASE_HOST = 'Host';
	public const DATABASE_USER = 'User';
	public const DATABASE_PASS = 'Pass';
	public const DATABASE_NAME = 'Name';

	private $databaseHost = '';
	private $databaseUser = '';
	private $databasePass = '';
	private $databaseName = '';
	private $raw = [];

	/**
	 * Config constructor.
	 * @param array $raw
	 * @throws ConfigWrongException
	 */
	public function __construct(array $raw)
	{
		$this->raw = $raw;
		if (!$this->configDatabase()) {
			throw new ConfigWrongException(self::DATABASE);
		}
	}

	/**
	 * Установка настроек подключения базы данных
	 * @return bool
	 */
	private function configDatabase(): bool
	{
		if (
			!array_key_exists(self::DATABASE, $this->raw)
			|| !array_key_exists(self::DATABASE_HOST, $this->raw[self::DATABASE])
			|| !array_key_exists(self::DATABASE_USER, $this->raw[self::DATABASE])
			|| !array_key_exists(self::DATABASE_PASS, $this->raw[self::DATABASE])
			|| !array_key_exists(self::DATABASE_NAME, $this->raw[self::DATABASE])
		) {
			return false;
		}
		$this->databaseHost = $this->raw[self::DATABASE][self::DATABASE_HOST];
		$this->databaseUser = $this->raw[self::DATABASE][self::DATABASE_USER];
		$this->databasePass = $this->raw[self::DATABASE][self::DATABASE_PASS];
		$this->databaseName = $this->raw[self::DATABASE][self::DATABASE_NAME];
		return true;
	}

	/**
	 * Хост БД
	 * @return string
	 */
	public function getDatabaseHost(): string
	{
		return $this->databaseHost;
	}

	/**
	 * Пароль БД
	 * @return string
	 */
	public function getDatabasePass(): string
	{
		return $this->databasePass;
	}

	/**
	 * Имя пользователя БД
	 * @return string
	 */
	public function getDatabaseUser(): string
	{
		return $this->databaseUser;
	}

	/**
	 * Имя БД
	 * @return string
	 */
	public function getDatabaseName(): string
	{
		return $this->databaseName;
	}

	/**
	 * Доступ к произвоьному параметру конфига по пути.
	 * Путь - ключи разделенные точкой
	 * @param string $path
	 * @return mixed
	 * @throws ConfigUnknownException
	 */
	public function getOption(string $path) {
		$arPath = explode('.',$path);
		/** @var mixed $value */
		$value = $this->raw;
		$found = false;
		foreach ($arPath as $key) {
			if (!array_key_exists($key,$value)) {
				throw new ConfigUnknownException($path);
			}
			$found = true;
			$value = $value[$key];
		}
		if (!$found) {
			throw new ConfigUnknownException($path);
		}
		return $value;
	}
}