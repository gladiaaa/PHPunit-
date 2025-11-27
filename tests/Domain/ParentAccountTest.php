<?php

declare(strict_types=1);

namespace App\Tests\Domain;

use App\Domain\ParentAccount;
use App\Domain\TeenWallet;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class ParentAccountTest extends TestCase
{
    public function test_can_create_parent_account(): void
    {
        $parent = new ParentAccount('Monique');
        $this->assertSame('Monique', $parent->getName());
    }

    public function test_can_add_wallets_for_teens(): void
    {
        $parent = new ParentAccount('Monique');
        $wallet = new TeenWallet('Alex');

        $parent->addTeenWallet($wallet);

        $this->assertSame($wallet, $parent->getWalletFor('Alex'));
    }

    public function test_cannot_add_two_wallets_with_same_name(): void
    {
        $parent = new ParentAccount('Monique');

        $parent->addTeenWallet(new TeenWallet('Alex'));

        $this->expectException(InvalidArgumentException::class);
        $parent->addTeenWallet(new TeenWallet('Alex'));
    }

    public function test_get_wallet_for_unknown_teen_throws(): void
    {
        $parent = new ParentAccount('Monique');

        $this->expectException(InvalidArgumentException::class);
        $parent->getWalletFor('Zoé');
    }

    public function test_can_compute_total_balance_of_all_teens(): void
    {
        $parent = new ParentAccount('Monique');

        $alex = new TeenWallet('Alex');
        $emma = new TeenWallet('Emma');

        $alex->deposit(15);
        $emma->deposit(25);

        $parent->addTeenWallet($alex);
        $parent->addTeenWallet($emma);

        $this->assertSame(40.0, $parent->getTotalBalance());
    }

    public function test_parent_can_apply_all_weekly_allowances_at_once(): void
    {
        $parent = new ParentAccount('Monique');

        $alex = new TeenWallet('Alex');
        $emma = new TeenWallet('Emma');

        $alex->setWeeklyAllowance(5);
        $emma->setWeeklyAllowance(10);

        $parent->addTeenWallet($alex);
        $parent->addTeenWallet($emma);

        $parent->applyAllWeeklyAllowances();

        $this->assertSame(5.0, $alex->getBalance());
        $this->assertSame(10.0, $emma->getBalance());
    }
}
