@php
    $links = ['facebook', 'instagram', 'linkedin', 'twitter'];
@endphp

<tr>
    <td align="center" valign="center" class=""
        style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
        <p class="text-center" style="color:#181C32; font-size: 16px; font-weight: 600; margin-bottom:9px">
            {{ seo('slogan') }}
        </p>
        <p style="margin-bottom:2px;font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif"
            class="text-center">Besoin de nous appeler ?
            <a href="tel:{{ settings('site_phone') }}" target="_blank"
                style="font-weight: 600">{{ settings('site_phone') }}
            </a>
        </p>
        <p style="margin-bottom:4px;font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif"
            class="text-center">Vous pouvez aussi nous contacter par email :
            <a href="mailto:{{ settings('site_email') }}" target="_blank"
                style="font-weight: 600">{{ settings('site_email') }}</a>.
        </p>
        <p class="text-center;"
            style="font-size: 13px; text-align:center; padding: 0 10px 10px 10px; font-weight: 500; color: #A1A5B7; font-family:Arial,Helvetica,sans-serif">
            {{ settings('help_availability') }}</p>
    </td>
</tr>
<tr>
    <td align="center" class="flex justify-center" valign="center" style="text-align:center; padding-bottom: 20px;">
        @foreach ($links as $item)
            @php
                $link = social_links($item);
            @endphp
            @if ($link)
                <a href="{{ $link->url ?? '#' }}" style="margin-right:10px">
                    <img alt="{{ $item }}" width="24"
                        src="{{ asset('/images/email/icon-' . $item . '.svg') }}" />
                </a>
            @endif
        @endforeach
    </td>
</tr>
<tr class="flex justify-center">
    <td align="center" valign="center"
        style="font-size: 13px; padding:0 15px; text-align:center; font-weight: 500; color: #A1A5B7;font-family:Arial,Helvetica,sans-serif">
        <p>&copy; Copyright {{ date('Y') }}
            <a href="{{ config('app.frontend_url') }}" rel="noopener" target="_blank"
                style="font-weight: 600;font-family:Arial,Helvetica,sans-serif; text-decoration: underline">
                {{ config('app.name') }}</a>&nbsp;
            | Tous droits r&eacute;serv&eacute;s.
        </p>
    </td>
</tr>
