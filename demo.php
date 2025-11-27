<?php
require __DIR__ . '/vendor/autoload.php';

use App\Domain\TeenWallet;
use App\Domain\ParentAccount;

//compte parent
$parent = new ParentAccount('Monique');

//compte ados
$alex = new TeenWallet('Alex');
$emma = new TeenWallet('Emma');

//dépots de base
$alex->deposit(20);
$emma->deposit(15);

//dépenses
$alex->spend(5, 'Snacks');
$emma->spend(3, 'Bus');

//budget hebdo
$alex->setWeeklyAllowance(10);
$emma->setWeeklyAllowance(8);

//lien comptes ados - parent
$parent->addTeenWallet($alex);
$parent->addTeenWallet($emma);

//Appliquer les budgets hebdo
$parent->applyAllWeeklyAllowances();

echo "===== MyWeeklyAllowance Demo =====\n\n";

echo "Parent : " . $parent->getName() . "\n\n";

foreach (['Alex', 'Emma'] as $teen) {
    $wallet = $parent->getWalletFor($teen);

    echo "Wallet de $teen\n";
    echo "- Solde : " . $wallet->getBalance() . " €\n";
    echo "- Transactions :\n";

    foreach ($wallet->getTransactions() as $t) {
        echo "   * {$t['type']} | {$t['amount']} €";
        if ($t['label']) {
            echo " ({$t['label']})";
        }
        echo "\n";
    }

    echo "\n";
}

echo "Solde total famille : " . $parent->getTotalBalance() . " €\n";
