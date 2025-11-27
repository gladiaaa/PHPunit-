<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\TeenWallet;
use InvalidArgumentException;
use RuntimeException;
use PHPUnit\Framework\TestCase;

class TeenWalletTest extends TestCase
{
    public function test_new_wallet_starts_with_zero_balance(): void
    {
        $wallet = new TeenWallet('Alex');
        $this->assertSame(0.0, $wallet->getBalance());
    }

    public function test_deposit_increases_balance(): void
    {
        $wallet = new TeenWallet('Alex');
        $wallet->deposit(20.0);

        $this->assertSame(20.0, $wallet->getBalance());
    }

    public function test_cannot_deposit_negative_or_zero_amount(): void
    {
        $wallet = new TeenWallet('Alex');

        $this->expectException(InvalidArgumentException::class);
        $wallet->deposit(0);
    }

    public function test_register_expense_decreases_balance(): void
    {
        $wallet = new TeenWallet('Alex');
        $wallet->deposit(30.0);

        $wallet->spend(10.0, 'Cinéma');

        $this->assertSame(20.0, $wallet->getBalance());
    }

    public function test_cannot_spend_more_than_balance(): void
    {
        $wallet = new TeenWallet('Alex');
        $wallet->deposit(10.0);

        $this->expectException(RuntimeException::class);
        $wallet->spend(20.0, 'Shopping');
    }

    public function test_cannot_spend_negative_or_zero_amount(): void
    {
        $wallet = new TeenWallet('Alex');
        $wallet->deposit(10.0);

        $this->expectException(InvalidArgumentException::class);
        $wallet->spend(0, 'Test');
    }

    public function test_can_set_weekly_allowance(): void
    {
        $wallet = new TeenWallet('Alex');
        $wallet->setWeeklyAllowance(15.0);

        $this->assertSame(15.0, $wallet->getWeeklyAllowance());
    }

    public function test_cannot_set_negative_or_zero_weekly_allowance(): void
    {
        $wallet = new TeenWallet('Alex');

        $this->expectException(InvalidArgumentException::class);
        $wallet->setWeeklyAllowance(0);
    }

    public function test_apply_weekly_allowance_increases_balance(): void
    {
        $wallet = new TeenWallet('Alex');
        $wallet->setWeeklyAllowance(10.0);

        $wallet->applyWeeklyAllowance();

        $this->assertSame(10.0, $wallet->getBalance());
    }

    public function test_apply_weekly_allowance_without_setting_it_throws(): void
    {
        $wallet = new TeenWallet('Alex');

        $this->expectException(RuntimeException::class);
        $wallet->applyWeeklyAllowance();
    }

    public function test_expenses_are_recorded_in_history(): void
    {
        $wallet = new TeenWallet('Alex');
        $wallet->deposit(50.0);
        $wallet->spend(15.0, 'Snacks');

        $history = $wallet->getTransactions();

        $this->assertCount(2, $history); // 1 dépôt + 1 dépense
        $this->assertSame('deposit', $history[0]['type']);
        $this->assertSame('expense', $history[1]['type']);
        $this->assertSame('Snacks', $history[1]['label']);
        $this->assertSame(15.0, $history[1]['amount']);
    }
}
