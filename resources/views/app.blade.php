<!DOCTYPE html>
<html class="h-full" data-theme="true" data-theme-mode="light" dir="ltr"
    lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title inertia>{{ config('app.name', 'Agora des Jeunes') }}</title>

    <!-- Seo -->
    @include('inc.seo')

    <!-- Favicons -->
    @include('inc.favicons')

    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/scss/app.scss'])

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @viteReactRefresh
    @routes
    @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
    @inertiaHead
</head>

<body class="antialiased flex h-full text-base text-gray-700">
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

    <!-- Modals -->
    @include('modals.share_profile')
    @include('modals.give_award')
    @include('modals.report_user')
    <!-- End of Modals -->
    <!-- End of Page -->

    <!-- Scripts -->
    {!! NoCaptcha::renderJs('fr', true, 'recaptchaCallback') !!}
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
    </script>
    <!-- End of Scripts -->
</body>

</html>
