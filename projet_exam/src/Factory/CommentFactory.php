<?php

namespace App\Factory;

use App\Entity\Comment;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;


final class CommentFactory extends PersistentProxyObjectFactory
{

    public function __construct()
    {
    }

    public static function class(): string
    {
        return Comment::class;
    }


    protected function defaults(): array|callable
    {
        return [

            'user' => UserFactory::random(),
            'center' => CenterFactory::random(),
            'publicationDate' => \DateTimeImmutable::createFromMutable(
                self::faker()->dateTimeBetween('-5 years', 'now')
            ),
            'content' => self::faker()->text(255),
             'rating' => self::faker()->numberBetween(1, 5) ,


        ];
    }


    protected function initialize(): static
    {
        return $this

        ;
    }
}
