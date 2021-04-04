<?php

declare(strict_types=1);

namespace App\Entity;

class Message
{
    // phpcs:disable Generic.WhiteSpace.ScopeIndent.IncorrectExact
    public function __construct(
        private string $twitterId,
        private string $twitterHandle,
        private string $part1,
        private string $part2,
        private string $part3
    ) {
        // phpcs:enable Generic.WhiteSpace.ScopeIndent.IncorrectExact
    }

    public function __toString(): string
    {
        return implode(' ', [ $this->part1, $this->part2, $this->part3 ]);
    }

    public function getTwitterId(): string
    {
        return $this->twitterId;
    }

    public function getTwitterHandle(): string
    {
        return $this->twitterHandle;
    }

    public function getPart1(): string
    {
        return $this->part1;
    }

    public function getPart2(): string
    {
        return $this->part2;
    }

    public function getPart3(): string
    {
        return $this->part3;
    }
}
