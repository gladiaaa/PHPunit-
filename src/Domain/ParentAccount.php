<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;

class ParentAccount
{
    private string $name;

    /** @var array<string, TeenWallet> */
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
            throw new InvalidArgumentException("Un wallet existe déjà pour $teen.");
        }

        $this->wallets[$teen] = $wallet;
    }

    public function getWalletFor(string $teen): TeenWallet
    {
        if (!isset($this->wallets[$teen])) {
            throw new InvalidArgumentException("Aucun wallet trouvé pour $teen.");
        }

        return $this->wallets[$teen];
    }

    public function getTotalBalance(): float
    {
        return array_sum(
            array_map(fn(TeenWallet $w) => $w->getBalance(), $this->wallets)
        );
    }

    public function applyAllWeeklyAllowances(): void
    {
        foreach ($this->wallets as $wallet) {
            if ($wallet->getWeeklyAllowance() !== null) {
                $wallet->applyWeeklyAllowance();
            }
        }
    }
}
