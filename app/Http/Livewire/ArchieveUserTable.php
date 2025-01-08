<?php

namespace App\Http\Livewire;


use App\Models\ArchieveDetail;
use App\Models\Detail;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;


class ArchieveUserTable extends DataTableComponent
{
    protected $model = ArchieveDetail::class; // Use the Detail model

    public function configure(): void
    {
        $this->setPrimaryKey('id') // Assuming 'id' is the primary key in the 'details' table
            ->setAdditionalSelects(['archieve_details.user_id as id']); // Update with 'details' table's primary key
        $this->setEagerLoadAllRelationsEnabled();
    }

    public function columns(): array
    {
        return [
            Column::make("Name", "name") // Adjust to match 'details' table fields
                ->sortable()
                ->searchable(),

            Column::make("Router", "router_name")
                ->sortable()
                ->searchable(),

            Column::make("Package", "package_name")
                ->sortable()
                ->searchable(),



            Column::make('Actions')
                ->label(fn($row) => view('components.actions-restore-user', ['row' => $row])),
        ];
    }

    public function builder(): Builder
    {
        return ArchieveDetail::query()
            //    ->where('role', 'user') // Assuming 'role' exists in 'details' table
            ->select(); // Specify additional selects as needed
    }
}


