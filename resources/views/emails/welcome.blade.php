@extends('layouts.email')

@section('content')
    <!--begin:Start card-->
    <x-emails.start-card title="Merci pour ton inscription !" :media="asset('images/email/icon-positive-vote-2.svg')" :actionUrl="config('app.url')"
        actionText="Activer Mon Compte">
        <p class="start-card-p"><b>Salut {{ $user->info->prenom }},</b></p>
        <p class="start-card-p">🌟 Félicitations, tu fais maintenant partie {{ config('app.name') }} ! </p>
        <p class="start-card-p">Ici, tu trouveras tout ce dont tu as besoin pour avancer :
            opportunités, formation, emploi, bourses,
            entrepreneuriat et bien plus encore.</p>
    </x-emails.start-card>
    <!--end:Start card-->

    <x-emails.list-wrapper title="Par où commencer ?" :list="$activities" />
@endsection
