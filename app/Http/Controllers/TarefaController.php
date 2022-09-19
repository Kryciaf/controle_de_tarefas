<?php

namespace App\Http\Controllers;

use App\Mail\NovaTarefaMail;
use App\Models\Tarefa;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TarefasExport;
use Barryvdh\DomPDF\Facade;

class TarefaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tarefa.index');
    }

    public function getTaskTable(Request $request)
    {
        $user_id = auth()->user()->id;

        $limit = $request->post('length') ?: 10;
        $offset = $request->post('start') ?: 0;

        $tarefas = Tarefa::select('tarefas.*')
            ->where('user_id', $user_id)->offset($offset)->limit($limit);

        $recordsTotal = $tarefas->count();

        //ordenação do datatable de forma dinâmica
        if(!empty($request->columns[ $request->order[0]['column'] ?? 0 ]['name']))
        {
            $tarefas->orderBy($request->columns[ $request->order[0]['column'] ?? 0 ]['name'],$request->order[0]['dir'] ?? 'desc');
        }

        $recordsFiltered = $tarefas->count();

        $json_data = array(
            "draw" => intval($request['draw']) ?: 0, // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => $recordsTotal ?? 0, // total number of records
            "recordsFiltered" => $recordsFiltered ?? 0, // total number of records after searching
            "data" => $tarefas->get()->toArray() ?? [], // data array
            "csrf_token" => csrf_token(),
        );

        return response()->json($json_data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatorParams = [
            'task' => 'required|min:2|max:200',
            'date_limit' => [
                'required', 'string', 'date_format:Y-m-d',//data no formato YYYY-MM-DD, validado por DateTime do PHP
            ],
        ];

        // Valida os campos enviados na requisção e barra se for preciso
        $validator = Validator::make($request->all(), $validatorParams);

        if ($validator->fails()) {
            $error = [];
            foreach ($validator->errors()->getMessages() as $erros) {
                $error = array_merge($error, $erros);
            }
            return Redirect::back()->withErrors($validator->errors());
        }

        $destinatario = auth()->user()->email;

        $tarefa = new Tarefa();
        $tarefa->task = $request->task;
        $tarefa->date_limit = $request->date_limit;
        $tarefa->user_id = auth()->user()->id;
        $tarefa->save();

        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));

        return \redirect()->route('tarefa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if ($tarefa->user_id == $user_id) {
            return view('tarefa.show', ['tarefa' => $tarefa]);
        }

        return view('acesso_negado');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if ($tarefa->user_id == $user_id) {
            $validatorParams = [
                'task' => 'required|min:2|max:200',
                'date_limit' => [
                    'required', 'string', 'date_format:Y-m-d',//data no formato YYYY-MM-DD, validado por DateTime do PHP
                ],
            ];

            // Valida os campos enviados na requisção e barra se for preciso
            $validator = Validator::make($request->all(), $validatorParams);

            if ($validator->fails()) {
                $error = [];
                foreach ($validator->errors()->getMessages() as $erros) {
                    $error = array_merge($error, $erros);
                }
                return Redirect::back()->withErrors($validator->errors());
            }

            $tarefa->task = $request->task;
            $tarefa->date_limit = $request->date_limit;
            $tarefa->save();

            return \redirect()->route('tarefa.index');
        }

        return view('acesso_negado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if ($tarefa->user_id == $user_id) {
            $tarefa->delete();

            return \redirect()->route('tarefa.index');
        }

        return view('acesso_negado');

    }

    public function export($extensao) {

        if (in_array($extensao, ['xlsx', 'csv'])) {
            //retorna o download de arquivo no formato XLSX com base na Export Tarefa
            return Excel::download(new TarefasExport, 'lista_tarefas.'.$extensao);
        }

        return \redirect()->route('tarefa.index');
    }

}
