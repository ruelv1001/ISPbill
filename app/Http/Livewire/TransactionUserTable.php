<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Transaction;
use App\Models\User;
class TransactionUserTable extends DataTableComponent
{
    protected $model = Transaction::class;
    public $userId; // Renamed from $transactions to better reflect the content

    public function mount($transactions)
    {
        $this->userId = $transactions; // We're actually receiving a user ID
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }


    public function columns(): array
    {
        return [
            Column::make("Transaction ID", "id")
                ->setTable('transaction')
                ->sortable()
                ->searchable(),
            Column::make("Full Name", "detail.name")
                ->sortable()
                ->searchable(),

            Column::make("Payment  method", "payment_method")
                ->setTable('transaction')
                ->sortable()
                ->searchable(),
            Column::make("Payment  Date", "payment_date")
                ->setTable('transaction')
                ->sortable()
                ->searchable(),
            Column::make("Payment  Amount", "payment_amount")
                ->setTable('transaction')
                ->sortable()
                ->searchable(),
            Column::make('Actions')
                ->label(fn($row) => view('components.action', ['row' => $row])),

        ];
    }
    public function builder(): Builder
    {
        return Transaction::query()
            ->where('transaction.user_id', $this->userId)
            ->orderBy('payment_date', 'desc');
    }

}
