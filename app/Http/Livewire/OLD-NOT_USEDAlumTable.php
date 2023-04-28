<?php

namespace App\Http\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\Alumne;
use Livewire\WithPagination;

class AlumTable extends DataTableComponent
{

    use WithPagination;
    protected $model = Alumne::class;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setDefaultSort('cognom1', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")
                ->sortable(),
            Column::make("Nom", "nom")
                ->sortable(),
            Column::make("Cognom1", "cognom1")
                ->sortable(),
            Column::make("Cognom2", "cognom2")
                ->sortable(),
            Column::make("Dni", "dni")
                ->sortable(),
            Column::make("Nie", "nie")
                ->sortable(),
            Column::make("Pas", "pas")
                ->sortable(),

        ];
    }
}
