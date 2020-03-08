<?php

namespace App\Domain\Model\Player;

class PlayerRole
{
    const BASE = 'BASE';
    const ESCOLTA = 'ESCOLTA';
    const ALERO = 'ALERO';
    const ALA_PIVOT = 'ALA-PIVOT';
    const PIVOT = 'PIVOT';

    /** @var string */
    private $role;

    /**
     * @throws InvalidRoleNameException
     */
    public function __construct(string $role)
    {
        if (!\in_array($role, self::roles())) {
            throw new InvalidRoleNameException('Invalid role name');
        }

        $this->role = $role;
    }

    public static function Base(): self
    {
        return new self(self::BASE);
    }

    public static function Escolta(): self
    {
        return new self(self::ESCOLTA);
    }

    public static function Alero(): self
    {
        return new self(self::ALERO);
    }

    public static function AlaPivot(): self
    {
        return new self(self::ALA_PIVOT);
    }

    public static function Pivot(): self
    {
        return new self(self::PIVOT);
    }

    /**
     * @return string[]
     */
    public static function roles(): array
    {
        return [self::BASE, self::ESCOLTA, self::ALERO, self::ALA_PIVOT, self::PIVOT];
    }

    public function role(): string
    {
        return $this->role;
    }
}
