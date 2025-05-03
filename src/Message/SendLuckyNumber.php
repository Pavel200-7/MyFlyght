<?php
namespace App\Message;

claSS SendLuckyNumber
{
    public function __construct(
        private readonly string $to,
        private readonly int $luckyNumber
    ){
    }

    public function getTo(): string
    {
        return $this->to;
    }

    public function getLuckyNumber(): int
    {
        return $this->luckyNumber;
    }
}