@extends('layouts.email')

@section('content')
    <!--begin:Start card-->
    <x-emails.start-card :title="'Invitation à rejoindre ' . config('app.name') . ' !'" :media="asset('images/email/invitation-icon.png')" :actionUrl="$url" actionText="Je Rejoins Maintenant">
        <p class="start-card-p"> 👋 <b>{{ $name }}</b>,</p>
        <p class="start-card-p">{{ $inviter->info->full_name ?? $inviter->email }} t'a invité à
            <a href="{{ $url }}" target="_blank">rejoindre {{ config('app.name') }}</a>
            .
        </p>
        <p class="start-card-p">Clique sur le lien ci-dessous pour t'inscrire en quelques secondes.</p>
    </x-emails.start-card>
    <!--end:Start card-->

    <tr>
        <td>
            <p class="text-center">Et si tu avais enfin un espace dédié à ton développementet ton avenir ?</p>
        </td>
    </tr>

    <x-emails.list-wrapper :title="'🎯 ' . config('app.name') . ', c’est LA PLATEFORME où tu bénéficieras :'" :list="$list" :showIndex="false" />
@endsection
