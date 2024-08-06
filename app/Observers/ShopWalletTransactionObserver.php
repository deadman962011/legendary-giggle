<?php

namespace App\Observers;

use App\Models\ShopWallet;
use App\Models\ShopWalletTransaction; 

class ShopWalletTransactionObserver
{
    /**
     * Handle the UserWalletTransaction "created" event.
     */
    public function created(ShopWalletTransaction $transaction): void
    {
        //
        $shopWallet = ShopWallet::findOrFail($transaction->wallet_id);

        switch ($transaction->type) {
            case 'increase':
                $newBalance=$shopWallet->balance += $transaction->amount;
                break;
            case 'reduce':
                $newBalance=$shopWallet->balance -= $transaction->amount;
                break;
        } 
        $shopWallet->update(['balance'=>$newBalance]);
    }

    /**
     * Handle the ShopWalletTransaction "updated" event.
     */
    public function updated(ShopWalletTransaction $transaction): void
    {
        //
    }

    /**
     * Handle the ShopWalletTransaction "deleted" event.
     */
    public function deleted(ShopWalletTransaction $transaction): void
    {
        //
    }

    /**
     * Handle the UserWalletTransaction "restored" event.
     */
    public function restored(ShopWalletTransaction $transaction): void
    {
        //
    }

    /**
     * Handle the UserWalletTransaction "force deleted" event.
     */
    public function forceDeleted(ShopWalletTransaction $transaction): void
    {
        //
    }
}
