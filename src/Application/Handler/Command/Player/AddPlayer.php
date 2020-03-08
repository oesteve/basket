<?php

namespace App\Application\Handler\Command\Player;

use App\Application\Command\Command;
use Symfony\Component\Validator\Constraints as Assert;

class AddPlayer implements Command
{
    /**
     * @Assert\NotBlank
     * @Assert\Positive
     *
     * @var int
     */
    private $number;

    /**
     * @Assert\NotBlank
     * @Assert\Length(
     *      min = 2,
     *      max = 50
     * )
     *
     * @var string
     */
    private $name;

    /**
     * @Assert\NotBlank
     * @Assert\Choice(callback={"\App\Domain\Model\Player\PlayerRole", "roles"})
     *
     * @var string
     */
    private $role;

    /**
     * @Assert\NotBlank
     * @Assert\Range(
     *      min = 0,
     *      max = 100,
     * )
     *
     * @var int
     */
    private $score;

    public function __construct(int $number, string $name, string $role, int $score)
    {
        $this->number = $number;
        $this->name = $name;
        $this->role = $role;
        $this->score = $score;
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getScore(): int
    {
        return $this->score;
    }
}
