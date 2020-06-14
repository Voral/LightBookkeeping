<?php


namespace App\Exception;

/**
 * В Queries/In передан пустой массив
 * Class QueryInEmptyException
 * @package App\Exception
 */
class QueryUnknownLogicException extends AppException
{
	private $logic;
	/**
	 * FieldException constructor.
	 */
	public function __construct($logic)
	{
		$this->logic = $logic;
		parent::__construct(
			sprintf('Unknown logic %d', $logic),
			AppException::QUERIES_UNKNOWN_LOGIC
		);
	}

	/**
	 * @return mixed
	 */
	public function getLogic()
	{
		return $this->logic;
	}
}