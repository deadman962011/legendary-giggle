<?php

namespace App\Observers;

use App\Models\UserWallet;
use App\Models\UserWalletTransaction;

class UserWalletTransactionObserver
{
    /**
     * Handle the UserWalletTransaction "created" event.
     */
    public function created(UserWalletTransaction $transaction): void
    {
        //
        $userWallet = UserWallet::findOrFail($transaction->wallet_id);

        switch ($transaction->type) {
            case 'increase':
                $newBalance=$userWallet->balance += $transaction->amount;
                break;
            case 'reduce':
                $newBalance=$userWallet->balance -= $transaction->amount;
                break;
        } 
        $userWallet->update(['balance'=>$newBalance]);
    }

    /**
     * Handle the UserWalletTransaction "updated" event.
     */
    public function updated(UserWalletTransaction $userWalletTransaction): void
    {
        //
    }

    /**
     * Handle the UserWalletTransaction "deleted" event.
     */
    public function deleted(UserWalletTransaction $userWalletTransaction): void
    {
        //
    }

    /**
     * Handle the UserWalletTransaction "restored" event.
     */
    public function restored(UserWalletTransaction $userWalletTransaction): void
    {
        //
    }

    /**
     * Handle the UserWalletTransaction "force deleted" event.
     */
    public function forceDeleted(UserWalletTransaction $userWalletTransaction): void
    {
        //
    }
}
