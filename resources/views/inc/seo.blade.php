<meta name="robots" content="index, follow">

<meta content="{{ seo('description') }}" name="description" />

<meta content="{{ config('app.url') }}" property="og:url" />
<meta content="website" property="og:type" />
<meta content="{{ app()->getLocale() }}" property="og:locale" />
<meta content="{{ config('app.name') }}" property="og:site_name" />

<!-- Open Graph -->
<meta content="{{ seo('og_title') }}" property="og:title" />
<meta content="{{ seo('description') }}" property="og:description" />
<meta content="/images/opengraph.jpeg" property="og:image" />

<!-- Twitter -->
<meta content="{{ config('app.url') }}" name="twitter:site" />
<meta content="{{ seo('og_title') }}" name="twitter:title" />
<meta content="{{ seo('description') }}" name="twitter:description" />
<meta content="/images/opengraph.jpeg" name="twitter:image" />
<meta content="@yourDevLab" name="twitter:creator" />
<meta content="summary_large_image" name="twitter:card" />

<link rel="canonical" href="{{ config('app.url') }}">
