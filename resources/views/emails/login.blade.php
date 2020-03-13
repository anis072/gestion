@component('mail::message')
# L'equipe de ########

Bienvenue parmi notre equipe de Travail

<p>Votre Mot de passe est:{{ $password }}</p>
<p>Votre role dans notre projet est:{{ $role }}</p>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
