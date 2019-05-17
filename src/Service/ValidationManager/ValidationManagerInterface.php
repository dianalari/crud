<?php

namespace App\Service\ValidationManager;

use App\Entity\DTOInterface;

/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/22/2018
 * Time: 3:28 PM
 */

/**
 * Interface ValidationManagerInterface
 */
interface ValidationManagerInterface
{
    /**
     * @param DTOInterface $DTO
     */
    public function validateDTO(DTOInterface $DTO): void;
}