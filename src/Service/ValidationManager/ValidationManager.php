<?php

declare(strict_types=1);

namespace App\Service\ValidationManager;

use App\Entity\DTOInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Created by PhpStorm.
 * User: diana.lari
 * Date: 11/22/2018
 * Time: 3:29 PM
 */
class ValidationManager implements ValidationManagerInterface
{
    /** @var ValidatorInterface $validator */
    private $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    /**
     * @param DTOInterface $DTO
     * @throws HttpException
     */
    public function validateDTO(DTOInterface $DTO): void
    {
        /** @var array $violations */
        $violations = $this->validator->validate($DTO);

        if (empty($violations)) {
            $errorMessage = "";
            /** @var ConstraintViolation $violation */
            foreach ($violations as $violation) {
                $errorMessage .= $violation->getMessage() . ' ';
            }
            throw new HttpException(400, $errorMessage);
        }
    }
}
