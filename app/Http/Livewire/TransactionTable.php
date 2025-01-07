<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;

use App\Models\Transaction;
use App\Models\User;
class TransactionTable extends DataTableComponent
{
    protected $model = Transaction::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['transaction.id as transaction_id']);
        // ->setTableRowUrl(function ($row) {
        //     return route('transaction.create', ['user' => $row->id]);
        // });
        $this->setEagerLoadAllRelationsEnabled();
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
            ->with('detail')
            ->select('transaction.*')
            ->orderBy('payment_date', 'desc');
    }
}
