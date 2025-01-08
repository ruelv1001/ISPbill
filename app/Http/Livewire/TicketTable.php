<?php

namespace App\Http\Livewire;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Ticket;
use Workbench\App\Models\User;

class TicketTable extends DataTableComponent
{
    protected $model = Ticket::class;
    
    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['tickets.id as id'])
            ->setTableRowUrl(function($row) {
                return route('ticket.show', $row);
            });
    }
    
    public function columns(): array
    {
        return [
            Column::make("Ticket ID", "number")
                ->sortable()
                ->searchable(),
            Column::make("Subject", "subject")
                ->sortable()
                ->searchable(),
            Column::make("Status", "status")
                ->sortable(),
            Column::make("Priority", "priority")
                ->sortable(),
            Column::make("Assignee", "assign")  
                ->format(function($value, $row) {
                    return $row->assignedUser->name ?? 'Unassigned';
                })
                ->sortable(),
            Column::make("Created by", "user_id")
                ->format(function($value, $row) {
                    return $row->creator->name ?? 'Unknown';
                })
                ->sortable(),
            Column::make("Created at", "created_at")
                ->format(function ($value) {
                    return Carbon::parse($value)->format('Y-m-d');
                }),
        ];
    }
    
    public function builder(): Builder
    {
        return Ticket::query()
            ->with(['assignedUser', 'creator'])
            ->when(auth()->user()->isUser(), function($query) {
                $query->where('tickets.user_id', auth()->id());
            });
    }
}