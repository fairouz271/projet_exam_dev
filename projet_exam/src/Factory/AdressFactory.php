<?php

namespace App\Factory;

use App\Entity\Adress;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;


final class AdressFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
    }

    public static function class(): string
    {
        return Adress::class;
    }


    protected function defaults(): array|callable
    {
        return [
            'adress' => self::faker()->address(255),
            'altitude' => self::faker()->randomFloat(2, 45.3, 46.1),
            'longitude' => self::faker()->randomFloat(2, 2.5, 4.0),
        ];
    }


    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Adress $adress): void {})
        ;
    }
}
