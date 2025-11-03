<?php

namespace App\Factory;

use App\Entity\User;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;


final class UserFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
    }

    public static function class(): string
    {
        return User::class;
    }


    protected function defaults(): array|callable
    {
        return [
            'email' => self::faker()->text(180),
            'familyName' => self::faker()->text(255),
            'firstName' => self::faker()->text(255),
            'password' => self::faker()->text(),
            'roles' => [],
        ];
    }

    protected function initialize(): static
    {
        return $this

        ;
    }
}
