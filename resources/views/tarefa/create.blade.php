@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Adicionar Tarefa</div>

                    <div class="card-body">
                        <form method="post" action="{{route('tarefa.store')}}">
                            @csrf
                            <div class="mb-3">
                                <label for="task" class="form-label">Tarefa</label>
                                <input type="text" name="task" class="form-control" id="task">
                                @if ($errors->has('task'))
                                    <span class="text-danger">{{ $errors->first('task') }}</span>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="date_limit" class="form-label">Data Limite Conclusão</label>
                                <input type="date" name="date_limit" class="form-control" id="date_limit">
                                @if ($errors->has('date_limit'))
                                    <span class="text-danger">{{ $errors->first('date_limit') }}</span>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">Cadastrar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
