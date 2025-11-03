<?php

namespace App\Factory;

use App\Entity\Center;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;


final class CenterFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
    }

    public static function class(): string
    {
        return Center::class;
    }


    protected function defaults(): array|callable
    {
        return [
            'adress' =>  AdressFactory::random(),
            'imagePath' => 'https://picsum.photos/200/300?random=' . self::faker()->uuid(),
            'name' => self::faker()->text(50),
            'phoneNumber' => self::faker()->phoneNumber(),
            'schedules' => self::faker()->paragraph(),
            'description' => self::faker()->paragraph(),

            'price' => self::faker()->numberBetween(1,50)
        ];
    }


    protected function initialize(): static
    {
        return $this

        ;
    }
}
