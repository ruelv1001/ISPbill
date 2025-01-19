<?php

namespace App\Http\Livewire;


use App\Models\Detail;
use Carbon\Carbon;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Filters\SelectFilter;

class UserTable extends DataTableComponent
{
    protected $model = Detail::class;
    public array $bulkActions = [
        'lockSelected' => 'Lock Selected',
        'unlockSelected' => 'Unlock Selected',
        'archiveSelected' => 'Archive Selected'
    ];

    public function configure(): void
    {
        $this->setPrimaryKey('id')
            ->setAdditionalSelects(['details.user_id as id'])
            ->setEagerLoadAllRelationsEnabled();
    }

    public function filters(): array
    {
        $packages = Detail::distinct()
        ->pluck('package_name', 'package_name')
        ->toArray();

    // Add "All" option
    $packageOptions = ['' => 'All'] + $packages;

        return [
            SelectFilter::make('Lock Status')
                ->options([
                    '' => 'All',
                    'lock' => 'Locked',
                    'unlock' => 'Unlocked',
                ])
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('is_lock', $value);
                }),

                SelectFilter::make('Package')
                ->options($packageOptions)
                ->filter(function(Builder $builder, string $value) {
                    $builder->where('package_name', $value);
                }),
            SelectFilter::make('Status')
                ->options([
                    '' => 'All',
                    'active' => 'Active',
                    'expired' => 'Expired',
                ])
                ->filter(function(Builder $builder, string $value) {
                    if ($value === 'active') {
                        $builder->where('service_details.active_due_date', '>', now());
                    } elseif ($value === 'expired') {
                        $builder->where('service_details.active_due_date', '<', now());
                    }
                }),
        ];
    }

    public function columns(): array
    {
        return [
            Column::make("Lock", "is_lock")
                ->sortable()
                ->searchable()
                ->format(function ($value, $row) {
                    $icon = $value === 'unlock'
                        ? '<i class="fas fa-unlock fa-lg text-green-500"></i>'
                        : '<i class="fas fa-lock fa-lg text-red-500"></i>';

                    return "<button onclick=\"toggleLock({$row->user_id})\">$icon</button>";
                })
                ->html(),
            Column::make("Name", "name")
                ->sortable()
                ->searchable(),
            Column::make("Package", "package_name")
                ->sortable()
                ->searchable(),
            Column::make("Remarks", "remarks")
                ->sortable()
                ->searchable(),
            Column::make("Expire", "service_details.active_due_date")
                ->sortable()
                ->searchable(),
            Column::make('Status')
                ->label(fn($row) => view('components.mt-status', ['row' => $row])),
            Column::make('Actions')
                ->label(fn($row) => view('components.actions', ['row' => $row])),
        ];
    }

    public function builder(): Builder
    {
        return Detail::query()
            ->join('service_details', 'service_details.user_id', '=', 'details.user_id')
            ->join('miktrotik_parameters', 'miktrotik_parameters.user_id', '=', 'details.user_id')
            ->select('details.*', 'miktrotik_parameters.*', 'service_details.active_due_date');
    }

    // Bulk action methods remain unchanged
    public function lockSelected()
    {
        if ($this->getSelected()) {
            Detail::whereIn('user_id', $this->getSelected())
                ->update(['is_lock' => 'lock']);

            session()->flash('message', 'Selected users have been locked.');
            $this->clearSelected();
        }
    }

    public function unlockSelected()
    {
        if ($this->getSelected()) {
            Detail::whereIn('user_id', $this->getSelected())
                ->update(['is_lock' => 'unlock']);

            session()->flash('message', 'Selected users have been unlocked.');
            $this->clearSelected();
        }
    }

    public function archiveSelected()
    {
        if ($this->getSelected()) {
            $unlockedDetails = Detail::whereIn('user_id', $this->getSelected())
                ->where('is_lock', '!=', 'lock')
                ->get();

            if ($unlockedDetails->isNotEmpty()) {
                $archiveDetails = $unlockedDetails->map(function ($detail) {
                    $array = $detail->toArray();
                    unset($array['created_at'], $array['updated_at']);
                    return $array;
                })->toArray();

                \DB::table('archieve_details')->insert($archiveDetails);
                Detail::whereIn('user_id', $unlockedDetails->pluck('user_id'))->delete();

                session()->flash('message', 'Selected unlocked users have been archived.');
            } else {
                session()->flash('message', 'No unlocked users found for archiving.');
            }

            $this->clearSelected();
        } else {
            session()->flash('message', 'No users selected.');
        }
    }
}
