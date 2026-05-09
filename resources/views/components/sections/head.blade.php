<head>
    <title>{{$page["meta_title"]}} | @tolgee("pages.index.meta_title_base", force_plain_text: true)</title>
    
    <!-- Icons -->
    <link rel="icon" type="image/png" href="{{asset("images/favicon.png")}}" />

    <!-- Meta -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{$page["meta_description"]}}">
    <meta name="theme-color" content="#e8644a"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <!-- Social Meta Tags -->
    <meta property="og:site_name" content="{{config("app.name")}}" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="{{config("app.url")}}" />
    <meta property="og:title" content="{{$page["meta_title"]}} - @tolgee("pages.index.meta_title_base", force_plain_text: true)" />
    <meta property="og:description" content="{{$page["meta_description"]}}" />
    <meta property="og:image:url" content="" />
    <meta property="og:image:alt" content="" />

    <!-- CSS -->
    @vite(['resources/css/app.css', 'resources/scss/theme.scss'])
    
    <script>
        window.dataLayer = window.dataLayer || [];
    </script>
</head>