<tr style="display: flex; justify-content: center; margin:0 60px 35px 60px">
    <td align="start" valign="start" style="padding-bottom: 10px;">
        <p class="text-center" style="color:#181C32; font-size: 18px; font-weight: 600; margin-bottom:13px">
            {{ $title }}
        </p>
        <!--begin::Wrapper-->
        <div style="background: #F9F9F9; border-radius: 12px; padding:35px 30px">
            @foreach ($list as $item)
                <!--begin::Item-->
                <div style="display:flex">
                    <!--begin::Media-->
                    <div
                        style="display: flex; justify-content: center; align-items: center; width:40px; height:40px; margin-right:13px">
                        <img alt="" src="{{ asset('images/email/icon-polygon.svg') }}" />
                        <span
                            style="position: absolute; color:var(--primary-color); font-size: 16px; font-weight: 600;">
                            {{ $showIndex ? $loop->iteration : '✅' }}
                        </span>
                    </div>
                    <!--end::Media-->
                    <!--begin::Block-->
                    <div>
                        <!--begin::Content-->
                        <div>
                            @if ($item['title'])
                                <!--begin::Title-->
                                <a href="{{ $item['url'] ?? '#' }}"
                                    style="color:#181C32; font-size: 14px; font-weight: 600;font-family:Arial,Helvetica,sans-serif">
                                    {{ $item['title'] }}
                                </a>
                                <!--end::Title-->
                            @endif
                            @isset($item['desc'])
                                <!--begin::Desc-->
                                <div
                                    style="color:#5E6278; font-size: 13px; font-weight: 500; padding-top:3px; margin:0;font-family:Arial,Helvetica,sans-serif">
                                    {!! $item['desc'] !!}
                                </div>
                                <!--end::Desc-->
                            @endisset
                        </div>
                        <!--end::Content-->
                        <!--begin::Separator-->
                        <div class="separator separator-dashed" style="margin:17px 0 15px 0"></div>
                        <!--end::Separator-->
                    </div>
                    <!--end::Block-->
                </div>
                <!--end::Item-->
            @endforeach
        </div>
        <!--end::Wrapper-->
    </td>
</tr>
