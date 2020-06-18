<?php


namespace App\Exception;

/**
 * В Update запрос не переданы значения для установки
 * Class QueryUpdateEmptyException
 * @package App\Exception
 */
class QueryUpdateEmptyException extends AppException
{
	/**
	 * FieldException constructor.
	 */
	public function __construct()
	{
		parent::__construct(
			'Update query does not contain fields for updating',
			AppException::QUERIES_EMPTY_UPDATE
		);
	}
}