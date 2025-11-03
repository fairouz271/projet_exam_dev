<?php

namespace App\Factory;

use App\Entity\Activity;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

final class ActivityFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
    }

    public static function class(): string
    {
        return Activity::class;
    }


    protected function defaults(): array|callable
    {
        return [
            'description' => self::faker()->paragraph(),
            'name' => self::faker()->text(255),
            'imagePath' => "https://picsum.photos/200/300",
        ];
    }


    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Activity $activity): void {})
        ;
    }
}
