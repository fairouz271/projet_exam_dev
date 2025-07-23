<?php

namespace App\Factory;

use App\Entity\Center;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Center>
 */
final class CenterFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return Center::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'adress' =>  AdressFactory::random(),
            'imagePath' => "https://picsum.photos/200/300",
            'name' => self::faker()->text(50),
            'phoneNumber' => self::faker()->phoneNumber(), // "07## ## ## ##"
            'schedules' => self::faker()->paragraph(),
//            'schedules' => [
//        'lundi'     => self::faker()->boolean(90) ? '08:00 - 18:00' : 'Fermé',
//        'mardi'     => self::faker()->boolean(90) ? '08:00 - 18:00' : 'Fermé',
//        'mercredi'  => self::faker()->boolean(70) ? '08:30 - 12:00' : 'Fermé',
//        'jeudi'     => self::faker()->boolean(90) ? '08:00 - 18:00' : 'Fermé',
//        'vendredi'  => self::faker()->boolean(90) ? '08:00 - 17:00' : 'Fermé',
//        'samedi'    => self::faker()->boolean(60) ? '10:00 - 16:00' : 'Fermé',
//        'dimanche'  => 'Fermé',
//    ],
            'price' => self::faker()->numberBetween(1,50)
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Center $center): void {})
        ;
    }
}
