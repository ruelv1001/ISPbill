<?php

namespace App\Http\Livewire;

use App\Models\ServiceDetails;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Ticket;
use App\Models\User;
class PayBillTable extends DataTableComponent
{
    protected $model = ServiceDetails::class;



    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['users.id as id'])
            ->setTableRowUrl(function ($row) {
                return route('paybill.create', ['user' => $row->id]);
            });

        $this->setEagerLoadAllRelationsEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Customer ID", "id")
                ->sortable()
                ->searchable(),
            Column::make("First Name", "detail.name")
                ->sortable()
                ->searchable(),
            Column::make("Package Name", "detail.package_name")
                ->sortable()
                ->searchable(),
            Column::make("Package Price", "detail.package_price")
                ->sortable()
                ->searchable(),

            Column::make("Due Date", "service_details.active_due_date")
                ->sortable()
                ->searchable(),
            Column::make("Due Date", "service_details.status")
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value === 'Inactive'
                        ? '<span class="text-red-500 font-bold">' . $value . '</span>'
                        : $value;
                })
                ->html()


        ];
    }

    public function builder(): Builder
    {
        return User::query()->where('role', 'user')->select();
    }
}
