<tr>
    <td align="center" valign="center" style="text-align:center; padding-bottom: 10px">
        <!--begin:Card content-->
        <div style="text-align:center; margin:0 15px 34px 15px">
            <!--begin:Logo-->
            <x-emails.logo />
            <!--end:Logo-->

            @if ($media)
                <!--begin:Media-->
                <div class="flex justify-center" style="margin-bottom: 15px">
                    <img alt="Image" src="{{ $media }}" style="max-width: 173px; max-height: 170px">
                </div>
                <!--end:Media-->
            @endif

            <!--begin:Title-->
            <div style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                <p class="text-center" style="margin-bottom:9px; color:#181C32; font-size: 22px; font-weight:700">
                    {{ $title }}
                </p>
            </div>
            <!--end:Title-->

            <!--begin:Slot-->
            <div
                style="font-size: 14px; font-weight: 500; margin-bottom: 27px; font-family:Arial,Helvetica,sans-serif;">
                {{ $slot }}
            </div>
            <!--end:Slot-->

            @if ($actionUrl)
                <!--begin:Action-->
                <x-emails.action-button :url="$actionUrl" :text="$actionText" />
                <!--begin:Action-->
            @endif
        </div>
        <!--end:Card content-->
    </td>
</tr>
