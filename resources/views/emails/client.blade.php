@component('mail::message')
# Introduction

<p>Votre Mot de Pass est :{{ $password }}</p>

Thanks,<br>
{{ config('app.name') }}
@endcomponent
