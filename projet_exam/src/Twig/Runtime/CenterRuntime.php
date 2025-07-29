<?php

namespace App\Twig\Runtime;

use App\Entity\Center;
use Symfony\Component\Serializer\Exception\ExceptionInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Twig\Extension\RuntimeExtensionInterface;

class CenterRuntime implements RuntimeExtensionInterface
{
    public function __construct(private readonly SerializerInterface $serializer)
    {
        // Inject dependencies if needed
    }

    /**
     * @param array<int, Center> $centers
     * @return string
     * @throws ExceptionInterface
     */
    public function getSerializedPoints(array $centers): string
    {
        $datas = [];
        foreach ($centers as $center) {
            if (null !== $address = $center->getAdress()) {
                $tmp = new \stdClass();
                $tmp->centerName = $center->getName();
                $tmp->latitude = $address->getAltitude();
                $tmp->longitude = $address->getLongitude();
                $datas[] = $tmp;
            }
        }
        return $this->serializer->serialize($datas, 'json');
    }
}
