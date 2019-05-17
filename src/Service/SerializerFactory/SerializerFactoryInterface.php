<?php
/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/13/2018
 * Time: 12:24 PM
 */

declare(strict_types=1);

/**
 * Description: Serializer Factory interface
 */

namespace App\Service\SerializerFactory;

use JMS\Serializer\Serializer;

/**
 * Interface SerializerClientInterface
 */
interface SerializerFactoryInterface
{
    /**
     * @return Serializer
     */
    public function getSerializer(): Serializer;
}