<?php
declare(strict_types=1);
namespace App\Model\User\Entity\User;


use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;


class TokenType extends StringType
{
    public const NAME = 'user_user_token';
    

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value instanceof Token ? $value->getValue() : $value;
    }
    

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return !empty($value) ? new Token($value) : null;
    }
    

    public function getName(): string
    {
        return self::NAME;
    }
}