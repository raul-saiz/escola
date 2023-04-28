<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="ca">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>@yield('pageTitle')</title>
    <!-- CSS files -->
    <base href="/">
    <link href="./dist/css/tabler.min.css?1674944402" rel="stylesheet" />
    <link href="./dist/css/tabler-flags.min.css?1674944402" rel="stylesheet" />
    <link href="./dist/css/tabler-payments.min.css?1674944402" rel="stylesheet" />
    <link href="./dist/css/tabler-vendors.min.css?1674944402" rel="stylesheet" />
    @stack('stylesheets')
    @livewireStyles
    <link href="./dist/css/demo.min.css?1674944402" rel="stylesheet" />
    <style>
        @import url('https://rsms.me/inter/inter.css');

        :root {
            --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
        }

        body {
            font-feature-settings: "cv03", "cv04", "cv11";
        }
    </style>
</head>

<body class=" layout-fluid">
    <script src="./dist/js/demo-theme.min.js?1674944402"></script>
    <div class="page">
        <!-- Sidebar -->
        @include('back.layouts.inc.menu')
        <div class="page-wrapper">
            <!-- Page header -->
            <div class="page-header d-print-none">
                @include('back.layouts.inc.header')
            </div>
            <!-- Page body -->
            <div class="page-body">
                @yield('content')
            </div>
            @include('back.layouts.inc.footer')
        </div>
    </div>

    <!-- Libs JS -->
    <script src="./dist/libs/apexcharts/dist/apexcharts.min.js?1674944402" defer></script>
    <script src="./dist/libs/jsvectormap/dist/js/jsvectormap.min.js?1674944402" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world.js?1674944402" defer></script>
    <script src="./dist/libs/jsvectormap/dist/maps/world-merc.js?1674944402" defer></script>
    <!-- Tabler Core -->
    <script src="./dist/js/tabler.min.js?1674944402" defer></script>
    @stack('scripts')
    @livewireScripts
    <script src="./dist/js/demo.min.js?1674944402" defer></script>

</body>

</html>
