<?php

namespace App;


use App\Exception\AppException;
use PHPUnit\Framework\TestCase;
use Zend\Stdlib\Exception\LogicException;

class ConfigTest extends TestCase
{
	private static $config = [
		Config::DATABASE => [
			Config::DATABASE_HOST => 'localhost',
			Config::DATABASE_NAME => 'database_name',
			Config::DATABASE_USER => 'user_name',
			Config::DATABASE_PASS => 'user_pass'
		]
	];

	/**
	 * Проверка инициализации параметров базы данных
	 * @throws Exception\ConfigWrongException
	 */
	public function testDatabase()
	{
		$cfg = new Config(self::$config);
		$dbConfig = self::$config[Config::DATABASE];
		$this->assertEquals($dbConfig[Config::DATABASE_HOST], $cfg->getDatabaseHost());
		$this->assertEquals($dbConfig[Config::DATABASE_NAME], $cfg->getDatabaseName());
		$this->assertEquals($dbConfig[Config::DATABASE_USER], $cfg->getDatabaseUser());
		$this->assertEquals($dbConfig[Config::DATABASE_PASS], $cfg->getDatabasePass());
	}

	/**
	 * Параметры можно получать по их пути. Где уровн разделены точкой
	 * @throws Exception\ConfigUnknownException
	 * @throws Exception\ConfigWrongException
	 */
	public function testPath()
	{
		$cfg = new Config(self::$config);
		$dbConfig = self::$config[Config::DATABASE];
		$this->assertEquals(
			$dbConfig[Config::DATABASE_HOST],
			$cfg->getOption('Database.Host')
		);
		$this->assertEquals(
			$dbConfig[Config::DATABASE_NAME],
			$cfg->getOption('Database.Name')
		);
		$this->assertEquals(
			$dbConfig[Config::DATABASE_USER],
			$cfg->getOption('Database.User')
		);
		$this->assertEquals(
			$dbConfig[Config::DATABASE_PASS],
			$cfg->getOption('Database.Pass')
		);
	}

	/**
	 * Параметры можно получать по их пути. Но при запросе отсутсвующего пути
	 * выкидывается исключение
	 * @throws Exception\ConfigUnknownException
	 * @throws Exception\ConfigWrongException
	 */
	public function testPathException()
	{
		$cfg = new Config(self::$config);
		$key = 'UndefinedSection.Undefined';
		$this->expectExceptionCode(AppException::CONFIG_UNKNOWN_KEY);
		$this->expectExceptionMessage(sprintf('Unknown config parameter path %s', $key));
		$cfg->getOption($key);
	}

	/**
	 * Проверка инициализации параметров базы данных.  Если нет обязательного параметра
	 * выбрасывается исключение
	 * @param string $key
	 * @throws LogicException
	 * @throws Exception\ConfigWrongException
	 */
	public function testDatabaseException(string $key)
	{
		$conf = self::$config;
		unset($conf[Config::DATABASE][$key]);
		$this->expectExceptionCode(AppException::CONFIG_WRONG);
		$this->expectExceptionMessage(sprintf('Invalid config in section %s', Config::DATABASE));
		if (new Config($conf)) {
			// Чтоб не ругался анализатор на попытку создать ни где не используемый объект
			throw new LogicException('It\'s impossible');
		}
	}

	public function databaseExceptionDataProvider(): array
	{
		return [
			[Config::DATABASE_HOST],
			[Config::DATABASE_NAME],
			[Config::DATABASE_USER],
			[Config::DATABASE_PASS],
		];
	}
}
