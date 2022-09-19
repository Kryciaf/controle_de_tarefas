@extends('layouts.app')

@section('content')

    <style>
        .linked {
            cursor: pointer;
        }
    </style>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-5">Tarefas</div>
                            <div class="col-7">
                                <div class="float-end">
                                    <a href="{{route('tarefa.create')}}" style="margin-right: 10px">Cria nova tarefa</a>
                                    <a href="{{route('tarefa.export', ['extensao' => 'xlsx'])}}" style="margin-right: 10px">Exportar XSLX</a>
                                    <a href="{{route('tarefa.export', ['extensao' => 'csv'])}}">Exportar CSV</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        @csrf
                        <table class="table table-hover" id="TasksDatatables"
                               style="width: 100% !important; clear: none !important; border-top: 0px !important; border-bottom: 1px #dddddd solid !important; font-size: 14px">
                            <thead class="col-md-12" style=" border-top: 0px !important; "></thead>
                            <tbody class="col-md-12"></tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">
    <script type="text/javascript" charset="utf8"
            src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

    <script type="text/javascript">

        let TaskDataTable;

        $(document).ready(function () {
            starterTasksDatatables();
        });

        function starterTasksDatatables() {
            const uriToTransactionDetails = `http://localhost/Testes/PHP/app_controle_tarefas/public/tarefa/`;
            const target = `#TasksDatatables`;
            var tokenGetValueBy = "input[name='_token']";
            var my_csrf_token = $(tokenGetValueBy).val();

            TaskDataTable = $(target).DataTable({
                destroy: true,
                rowCallback: function (row, data) {
                    $(row)
                        .addClass('linked')
                        .attr('onclick', `location.href = '` + uriToTransactionDetails + data.id + `';`);
                    return row;
                },
                columns: [
                    {
                        data: 'id', name: 'tarefas.id', render: function (data, type, row) {
                            return row.id;
                        }, title: 'ID', orderable: true,
                    },
                    {
                        data: 'task', name: 'tarefas.task', render: function (data, type, row) {
                            return row.task;
                        }, title: 'Tarefa', orderable: true,
                    },
                    {
                        data: 'task', name: 'tarefas.date_limit', render: function (data, type, row) {
                            return row.date_limit;
                        }, title: 'Data Limite de Conclusão', orderable: true,
                    },
                ],
                dom: '<"dataTables_length d-flex justify-content-end w-100"<"toolbox"l>> Pfrtip',
                processing: true,
                pageLength: 25,
                serverSide: true,
                aaSorting: [[0, 'desc']],
                searching: false,
                paging: true,
                ajax: {
                    url: "{{route('task_datatable')}}",
                    method: "post",
                    data: getAllFilters(my_csrf_token),
                    done: function ({csrf_token}) {
                        $(tokenGetValueBy).val(csrf_token);
                        return true;
                    },
                },
                language: {
                    sZeroRecords: "Nenhum registro encontrado",
                    lengthMenu: "Mostrando _MENU_ registros por página",
                    sInfo: "Mostrando _START_ ao _END_ de _TOTAL_ registro(s)",
                    sInfoEmpty: "Mostrando 0 ao 0 de 0 registros",
                    sInfoFiltered: "(filtrado de _MAX_ registros)",
                    sSearch: "Pesquisar: ",
                    processing: `<div class="d-flex justify-content-center align-items-center">
                    <div class="spinner-border text-primary m-2" role="status"></div> Buscando registros...
                </div>`,
                    oPaginate: {"sFirst": "Início", "sPrevious": "Anterior", "sNext": "Próximo", "sLast": "Último"}
                },
            });
        }

        function getAllFilters(token) {
            return {
                "_token": token,
            }
        }

    </script>

@endsection
