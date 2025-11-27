<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

class ParentAccount
{
    private string $name;

    private array $wallets = []; 

    public function __construct(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function addTeenWallet(TeenWallet $wallet): void
    {
        $teen = $wallet->getTeenName();

        if (isset($this->wallets[$teen])) {
            throw new InvalidArgumentException("Wallet already exists");
        }

        $this->wallets[$teen] = $wallet;
    }

    public function getWalletFor(string $teen): TeenWallet
    {
        if (!isset($this->wallets[$teen])) {
            throw new InvalidArgumentException("Wallet not found");
        }

        return $this->wallets[$teen];
    }

    public function getTotalBalance(): float
    {
        $total = 0;

        foreach ($this->wallets as $w) {
            $total += $w->getBalance();
        }

        return $total;
    }

    public function applyAllWeeklyAllowances(): void
    {
        foreach ($this->wallets as $w) {
            if ($w->getWeeklyAllowance() !== null) {
                $w->applyWeeklyAllowance();
            }
        }
    }
}
