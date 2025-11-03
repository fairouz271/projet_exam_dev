<?php

namespace App\Factory;

use App\Entity\Image;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Image>
 */
final class ImageFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
    }

    public static function class(): string
    {
        return Image::class;
    }

    protected function defaults(): array|callable
    {
        return [
            'path' => 'https://picsum.photos/200/300?random=' . self::faker()->uuid(),
            'center' => CenterFactory::new(),
        ];
    }


    protected function initialize(): static
    {
        return $this

        ;
    }
}
