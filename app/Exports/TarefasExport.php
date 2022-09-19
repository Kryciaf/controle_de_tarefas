<?php

namespace App\Exports;

use App\Models\Tarefa;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TarefasExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //retorna a collection formada por todas as tarefas relacioandas ao usuário logado, pelo relacionamento nas models
        return auth()->user()->tarefas;
    }

    public function headings(): array
    {
        return ['ID da Tarefa', 'Tarefa', 'Data Limite Conclusão'];
    }

    public function map($row): array
    {
        return [
            $row->id,
            $row->task,
            date('d/m/Y', strtotime($row->date_limit))
        ];
    }
}
