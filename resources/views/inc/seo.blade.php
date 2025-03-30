<meta name="description" content="{{ $meta['description'] ?? seo('description') }}">
<meta name="keywords" content="{{ $meta['keywords'] ?? seo('keywords') }}">
<meta name="author" content="{{ $page['props']['dev']['name'] ?? 'Your DevLab' }}">

<!-- Open Graph -->
<meta content="{{ url()->current() }}" property="og:url" />
<meta content="{{ config('app.name') }}" property="og:site_name" />
<meta content="{{ seo('og_title') }}" property="og:title" />
<meta content="{{ $meta['description'] ?? seo('description') }}" property="og:description" />
<meta content="{{ asset('images/opengraph.jpeg') }}" property="og:image" />
<meta content="website" property="og:type" />
<meta content="{{ app()->getLocale() }}" property="og:locale" />

<!-- Twitter -->
<meta content="{{ config('app.url') }}" name="twitter:site" />
<meta content="{{ seo('title') }}" name="twitter:title" />
<meta content="{{ $meta['description'] ?? seo('description') }}" name="twitter:description" />
<meta content="{{ asset('images/opengraph.jpeg') }}" name="twitter:image" />
<meta content="@yourDevLab" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />

{!! \App\Meta::render() !!}
