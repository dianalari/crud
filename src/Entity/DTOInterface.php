<?php
/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/22/2018
 * Time: 3:22 PM
 */

namespace App\Entity;


interface DTOInterface
{
    /**
     * @return array
     */
    public function toArray() : array;
}