<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title inertia>{{ config('app.name', 'Agora des Jeunes') }}</title>

    <!-- Seo -->
    @include('inc.seo')

    <!-- Favicons -->
    @include('inc.favicons')

    <!-- Styles -->
    @vite(['resources/css/home.css', 'resources/scss/app.scss'])
    <link href="{{ asset('/cdn.prod.website-files.com/67590e9b756ef477159ae9e4/css/notefye.webflow.cd2157501.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- Scripts -->
    <script type="text/javascript">
        ! function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
                .className += t + "touch")
        }(window, document);
    </script>
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body>
    @inertia

    <script
        src="{{ asset('/d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c887ab.js?site=67590e9b756ef477159ae9e4') }}"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>
</body>

</html>
