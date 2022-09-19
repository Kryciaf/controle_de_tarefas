@component('mail::message')
# {{ $tarefa }}

Data Limite de Conclusão: {{ $date_limit }}

@component('mail::button', ['url' => $url])
Clique aqui para ver a tarefa
@endcomponent

Att,<br>
{{ config('app.name') }}
@endcomponent
