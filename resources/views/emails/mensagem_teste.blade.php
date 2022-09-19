@component('mail::message')
# Introdução

Corpo da Mensagem

@component('mail::button', ['url' => ''])
Botão
@endcomponent

Obrigada,<br>
{{ config('app.name') }}
@endcomponent
