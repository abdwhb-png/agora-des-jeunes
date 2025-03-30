<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <title inertia>{{ config('app.name', 'Agora des Jeunes') }}</title>
    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="canonical" href="{{ config('app.url') }}">

    <!-- Seo -->
    @include('inc.seo')
    <!-- End of Seo -->

    <!-- Favicons -->
    @include('inc.favicons')
    <!-- End of Favicons -->

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap"
        rel="stylesheet" />
    <!-- End of Fonts -->

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/scss/app.scss'])
    {{-- @vite(['resources/css/home.css']) --}}
    <!-- End of Styles -->

    <!-- Scripts -->
    <script type="text/javascript">
        ! function(o, c) {
            var n = c.documentElement,
                t = " w-mod-";
            n.className += t + "js", ("ontouchstart" in o || o.DocumentTouch && c instanceof DocumentTouch) && (n
                .className += t + "touch")
        }(window, document);
    </script>

    @viteReactRefresh
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
    <!-- End of Scripts -->
</head>

<body class="">
    <!-- Theme Mode -->
    <script>
        const defaultThemeMode = 'light'; // light|dark|system
        let themeMode;

        if (document.documentElement) {
            if (localStorage.getItem('theme')) {
                themeMode = localStorage.getItem('theme');
            } else if (document.documentElement.hasAttribute('data-theme-mode')) {
                themeMode = document.documentElement.getAttribute('data-theme-mode');
            } else {
                themeMode = defaultThemeMode;
            }

            if (themeMode === 'system') {
                themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }

            document.documentElement.classList.add(themeMode);
        }
    </script>
    <!-- End of Theme Mode -->

    <!-- Page -->
    <!-- Base -->
    @inertia
    <!-- End of Base -->
    <!-- End of Page -->

    <!-- Main Scripts -->
    <script
        src="{{ asset('/d3e54v103j8qbb.cloudfront.net/js/jquery-3.5.1.min.dc5e7f18c887ab.js?site=67590e9b756ef477159ae9e4') }}"
        type="text/javascript" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous">
    </script>

    <script>
        function refreshPage() {
            window.location.reload();
        }

        function goBack(url = null) {
            if (url) {
                window.location.replace(url);
            } else {
                window.history.back();
            }
        }

        function loadStyles(items, idPrefix, remove = false) {
            items.forEach((item, index) => {
                const id = idPrefix + "_" + index;
                const existent = document.getElementById(id);

                if (remove && existent) {
                    document.head.removeChild(existent);
                } else if (!existent) {
                    const s = document.createElement("link");
                    s.rel = "stylesheet";
                    s.id = id;
                    s.type = "text/css";
                    s.href = item;
                    document.head.appendChild(s);
                }
            });
        }

        function loadScripts(items, idPrefix, remove = false) {
            items.forEach((item, index) => {
                const id = idPrefix + "_" + index;
                const existent = document.getElementById(id);
                if (remove && existent) {
                    document.body.removeChild(existent);
                } else if (!existent) {
                    const s = document.createElement("script");
                    s.src = item;
                    s.id = id;
                    document.body.appendChild(s);
                }
            });
        }
    </script>
    <!-- End of Main Scripts -->

    @if (Route::currentRouteName() === 'faqs')
        <script type="application/ld+json">
            {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [
                {
                "@type": "Question",
                "name": "Comment créer un CV sur {{ config('app.name') }} ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Connecte-toi à ton compte, va dans la section 'Création de CV', remplis les informations demandées et télécharge ton CV."
                }
                },
                {
                "@type": "Question",
                "name": "Comment rechercher un emploi sur la plateforme ?",
                "acceptedAnswer": {
                    "@type": "Answer",
                    "text": "Rends-toi dans la section 'Recherche d'emploi', utilise les filtres et postule aux offres qui t’intéressent."
                }
                }
            ]
            }
            </script>
    @endif
</body>

</html>
