<?php

namespace App\Http\Livewire;


use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class UserTable extends DataTableComponent
{
    protected $model = User::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['users.id as id']);
        // ->setTableRowUrl(function ($row) {
        //     return route('users.show', $row);
        // });
        $this->setEagerLoadAllRelationsEnabled();

    }

    public function columns(): array
    {
        return [
            Column::make("Name", "detail.name")
                ->sortable()
                ->searchable(),

            Column::make("Router", "detail.router_name")
                ->sortable()
                ->searchable(),
            Column::make("Package", "detail.package_name")
                ->sortable()
                ->searchable(),

            Column::make("Lock", "detail.is_lock")
                ->sortable()
                ->searchable()
                ->format(function ($value) {
                    return $value === 'unlock' // Check for 'unlock'
                        ? '<span class="text-green-500"><i class="fas fa-unlock fa-lg"></i> Unlock</span>'
                        : '<span class="text-red-500"><i class="fas fa-lock fa-lg"></i> Lock</span>';
                })
                ->html(),
            Column::make('Actions')->label(fn($row) => view('components.actions', ['row' => $row])),
        ];
    }



    public function builder(): Builder
    {
        return User::query()
            ->where('role', 'user') // Only show users with role = 'user'
            ->select();  // You can specify any other fields you want to select here if needed
    }



}
