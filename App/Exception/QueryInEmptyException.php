<?php


namespace App\Exception;

/**
 * В Queries/In передан пустой массив
 * Class QueryInEmptyException
 * @package App\Exception
 */
class QueryInEmptyException extends AppException
{
	/**
	 * FieldException constructor.
	 */
	public function __construct()
	{

		parent::__construct(
			'An empty array was passed to the expression',
			AppException::QUERIES_EMPTY_ARRAY
		);
	}
}