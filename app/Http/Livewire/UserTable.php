<?php

namespace App\Http\Livewire;


use App\Models\Detail;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class UserTable extends DataTableComponent
{
    protected $model = Detail::class; 

    public function configure(): void
    {
        $this->setPrimaryKey('id') 
            ->setAdditionalSelects(['details.user_id as id']); 
        $this->setEagerLoadAllRelationsEnabled();
    }

    public function columns(): array
    {
        
        return [
            Column::make("Lock", "is_lock")
            ->sortable()
            ->searchable()
            ->format(function ($value) {
                return $value === 'unlock'
                    ? '<span class="text-green-500"><i class="fas fa-unlock fa-lg"></i> </span>'
                    : '<span class="text-red-500"><i class="fas fa-lock fa-lg"></i> </span>';
            })
            ->html(),
            
            Column::make("Name", "name") 
                ->sortable()
                ->searchable(),

            Column::make("Router", "router_name")
                ->sortable()
                ->searchable(),

            Column::make("Package", "package_name")
                ->sortable()
                ->searchable(),

          

            Column::make('Actions')
                ->label(fn($row) => view('components.actions', ['row' => $row])),
        ];
    }

    public function builder(): Builder
    {
        return Detail::query()
            //    ->where('role', 'user') // Assuming 'role' exists in 'details' table
            ->select(); // Specify additional selects as needed
    }
}


