<?php
declare(strict_types=1);
namespace App\Container\Model\User\Service;


use DateInterval;
use App\Model\User\Service\ResetTokenizer;

class ResetTokenizerFactory
{


	public function create($interval) :ResetTokenizer
	{
		return new ResetTokenizer(new DateInterval($interval));
	}
}