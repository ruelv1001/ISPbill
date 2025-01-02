<?php

namespace App\Http\Livewire;


use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class UserManagementTable extends DataTableComponent
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
            Column::make("Router", "name")
            ->sortable()
            ->searchable(),
            Column::make("Email", "email")
                ->sortable()
                ->searchable(),
            Column::make("Role", "role")
                ->sortable()
                ->searchable(),
        
            Column::make("Member Since", "created_at")
                ->format(function ($value) {
                    return Carbon::parse($value)->format('Y-m-d');
                }),
            Column::make('Actions')
                ->label(fn($row) => view('components.actions-user-management', ['row' => $row])),
        ];
    }


    public function builder(): Builder
    {
        return User::query()
        ->whereIn('role', ['cashier', 'technician'])    
        ->select();
    }



}
