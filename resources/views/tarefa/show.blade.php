@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Editar {{ $tarefa->task }}</div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                <p class="text-muted mt-4 pt-2">{{session('success')}}</p>
                            </div>
                        @endif

                        <form method="post" action="{{route('tarefa.update', ['tarefa' => $tarefa->id])}}">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="task" class="form-label">Tarefa</label>
                                <input type="text" name="task" class="form-control" id="task" value="{{$tarefa->task}}">
                                @if ($errors->has('task'))
                                    <span class="text-danger">{{ $errors->first('task') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="date_limit" class="form-label">Data Limite Conclusão</label>
                                <input type="date" name="date_limit" class="form-control" id="date_limit"
                                       value="{{$tarefa->date_limit}}">
                                @if ($errors->has('date_limit'))
                                    <span class="text-danger">{{ $errors->first('date_limit') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Atualizar</button>
                            <form id="form_{{$tarefa->id}}" method="post" action="{{route('tarefa.destroy', ['tarefa' => $tarefa->id])}}">
                                @method('DELETE')
                                @csrf
                                <button type="submit" class="btn btn-danger" style="float: right">Excluir</button>
                            </form>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
