<?php
/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/13/2018
 * Time: 12:21 PM
 */

declare(strict_types=1);

namespace App\Service\SerializerFactory;

use JMS\Serializer\Serializer;
use JMS\Serializer\SerializerBuilder;

class SerializerFactory implements SerializerFactoryInterface
{
    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer
    {
        return SerializerBuilder::create()->build();
    }
}