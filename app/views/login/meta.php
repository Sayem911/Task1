<meta charset="utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
<meta property="og:title" content="{{ @website.title }}" />
<meta property="og:description" content="{{ @website.slogan }}. {{ @website.slogan2 }}." />
<meta property="og:url" content="{{ Helper::baseUrl() }}" />
<meta property="og:type" content="website" />
<meta property="og:image" content="{{ Helper::baseUrl() }}assets/images/background-header.png" />

<title>{{ @website.title . ' | ' . @vars.title }}</title>

<link rel="apple-touch-icon" sizes="57x57" href="{{ @BASE }}/assets/images/icons/cropped-Favicon-1-32x32.jpg">
<link rel="apple-touch-icon" sizes="60x60" href="{{ @BASE }}/assets/images/icons/cropped-Favicon-1-32x32.jpg">
<link rel="apple-touch-icon" sizes="72x72" href="{{ @BASE }}/assets/images/icons/cropped-Favicon-1-32x32.jpg">
<link rel="apple-touch-icon" sizes="76x76" href="{{ @BASE }}/assets/images/icons/cropped-Favicon-1-32x32.jpg">
<link rel="manifest" href="{{ @BASE }}/assets/images/icons/manifest.json">
<link rel="mask-icon" href="{{ @BASE }}/assets/images/icons/safari-pinned-tab.svg" color="#5bbad5">
<link rel="shortcut icon" href="{{ @BASE }}/assets/images/icons/cropped-Favicon-1-32x32.jpg">
<meta name="msapplication-TileColor" content="#da532c">
<meta name="msapplication-config" content="{{ @BASE }}/assets/images/icons/browserconfig.xml">
<meta name="theme-color" content="#ffffff">

  <link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/vendor/semantic/2.4.1/semantic.min.css">
<link rel="stylesheet" type="text/css" href="{{@BASE}}/assets/css/app.css">

<script src="//code.jquery.com/jquery-1.12.3.min.js"></script>
<script src="https://www.google.com/recaptcha/api.js"></script>
<script src="{{@BASE}}/assets/vendor/semantic/2.4.1/semantic.min.js"></script>
<script src="{{@BASE}}/assets/js/app{{ @MINIFIED_JS?'.min':'' }}.js"></script>

<include href="{{ @MINIFIED_JS ? @tpl.min.js.login : @tpl.js.login }}" />