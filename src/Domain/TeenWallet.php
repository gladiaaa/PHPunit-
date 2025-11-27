<?php

declare(strict_types=1);

namespace App\Domain;

use InvalidArgumentException;
use RuntimeException;

class TeenWallet
{
    private string $teenName;
    private float $balance = 0.0;
    private ?float $weeklyAllowance = null;

    /**
     * @var array<int, array{
     *     type: string,
     *     amount: float,
     *     label: ?string
     * }>
     */
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
            throw new InvalidArgumentException('Le montant déposé ne peux pas être négatif.');
        }

        $this->balance += $amount;

        $this->transactions[] = [
            'type' => 'deposit',
            'amount' => $amount,
            'label' => null,
        ];
    }

    public function spend(float $amount, string $label): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Le montant des dépenses ne peux pas être négatif.');
        }

        if ($amount > $this->balance) {
            throw new RuntimeException('Fonds insuffisant.');
        }

        $this->balance -= $amount;

        $this->transactions[] = [
            'type' => 'expense',
            'amount' => $amount,
            'label' => $label,
        ];
    }

    public function setWeeklyAllowance(float $amount): void
    {
        if ($amount <= 0) {
            throw new InvalidArgumentException('Le montant hebdomadaire doit-être positif.');
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
            throw new RuntimeException('Montant hebdomadaire non définis .');
        }

        $this->deposit($this->weeklyAllowance);
    }

    /**
     * @return array<int, array{
     *     type: string,
     *     amount: float,
     *     label: ?string
     * }>
     */
    public function getTransactions(): array
    {
        return $this->transactions;
    }
}
