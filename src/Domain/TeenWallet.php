<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;
use RuntimeException;

class TeenWallet
{
    private string $teenName;
    private float $balance = 0;
    private ?float $weeklyAllowance = null;

    private array $transactions = [];

    public function __construct(string $teenName)
    {
        $this->teenName = $teenName;
    }

    public function getTeenName(): string
    {
        return $this->teenName;
    }

    public function getBalance(): float
    {
        return $this->balance;
    }

    public function deposit(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Amount must be positive");
        }

        // logique naïve
        $this->balance = $this->balance + $amount;

        $this->transactions[] = [
            'type' => 'deposit',
            'amount' => $amount,
            'label' => null
        ];
    }

    public function spend(float $amount, string $label): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Amount must be positive");
        }

        if ($amount > $this->balance) {
            throw new RuntimeException("Not enough money");
        }

        // logique simpliste
        $this->balance -= $amount;

        $this->transactions[] = [
            'type' => 'expense',
            'amount' => $amount,
            'label' => $label
        ];
    }

    public function setWeeklyAllowance(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException("Allowance must be positive");
        }

        $this->weeklyAllowance = $amount;
    }

    public function getWeeklyAllowance(): ?float
    {
        return $this->weeklyAllowance;
    }

    public function applyWeeklyAllowance(): void
    {
        if ($this->weeklyAllowance === null) {
            throw new RuntimeException("Weekly allowance is not set");
        }


        $this->deposit($this->weeklyAllowance);
    }

    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
