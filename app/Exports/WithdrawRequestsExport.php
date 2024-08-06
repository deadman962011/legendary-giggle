<?php


namespace App\Exports;
 
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\UserWithdrawBalanceRequest;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\Crypt;


class WithdrawRequestsExport implements FromCollection, WithHeadings,WithMapping
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    { 
        return collect($this->data);
        // return UserWithdrawBalanceRequest::whereIn('id', $this->ids)->with('BankAccount')->get();
 
    }



    public function map($row): array
    { 

        // Crypt::decryptString
        return [
            $row->id,
            $row->amount,
            $row->BankAccount->bank_name,
            Crypt::decryptString($row->BankAccount->full_name),
            Crypt::decryptString($row->BankAccount->account_number),
            Crypt::decryptString($row->BankAccount->iban),
            $row->created_at
        ];
    }

    public function headings(): array
    {
        return [
            'ID',
            'Amount',
            'Bank Name',
            'Full Name',
            'Bank Account Number',
            'Bank Account Iban',
            'Created At',
        ];
    }
}



// namespace App\Exports;

// use App\Models\WithdrawRequest;
// use Maatwebsite\Excel\Concerns\FromCollection;

// class WithdrawRequestsExport implements FromCollection
// {
//     /**
//     * @return \Illuminate\Support\Collection
//     */
//     public function collection()
//     {
//         return WithdrawRequest::all();
//     }
// }


?>