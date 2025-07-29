<?php

namespace App\Twig\Extension;

use App\Twig\Runtime\CenterRuntime;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class CenterExtension extends AbstractExtension
{

    public function getFunctions(): array
    {
        return [
            new TwigFunction('getSerializedPoints', [CenterRuntime::class, 'getSerializedPoints']),
        ];
    }
}
