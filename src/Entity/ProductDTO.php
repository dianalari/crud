<?php
declare(strict_types=1);

namespace App\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;


class ProductDTO implements DTOInterface
{
    /**
     * @Assert\NotBlank(message="Product name should not be blank.")
     * @Assert\Length(
     *     min = 2,
     *     max = 45,
     *     minMessage = "Product name must be at least {{ limit }} characters long.",
     *     maxMessage = "Product name cannot be longer than {{ limit }} characters."
     * )
     * @Assert\Type("string")
     *
     * @Type("string")
     */
    private $name;

    /**
     * @Assert\NotBlank(message="Product description should not be blank.")
     * @Assert\Length(
     *     min = 10,
     *     max = 200,
     *     minMessage = "Product description must be at least {{ limit }} characters long.",
     *     maxMessage = "Product description cannot be longer than {{ limit }} characters."
     * )
     * @Assert\Type("string")
     *
     * @Type("string")
     */
    private $description;

    /**
     * @Assert\NotBlank(message="Product price should not be blank.")
     * @Assert\Type(type="float")
     *
     * @Type("float")
     */
    private $price;

    public function __construct(string $name, string $description, float $price)
    {
        $this->name = $name;
        $this->description = $description;
        $this->price = $price;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
        ];
    }
}
