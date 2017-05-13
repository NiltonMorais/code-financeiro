<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{asset('css/site.css')}}" rel="stylesheet">

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
                'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
<div id="app">
    <header>
        <?php
        $menuConfig = [
                'auth' => (boolean)Auth::check(),
                'name' => Auth::check() ? Auth::user()->name : '',
                'menus' => [
                        [
                                'name' => 'Home',
                                'url' => route('site.home'),
                                'active' => isRouteActive('site.home')
                        ],
                ],
                'menusDropdown' => [],
                'urlLogout' => env('URL_SITE_LOGOUT'),
                'csrfToken' => csrf_token(),
        ];
        ?>
        <site-menu :config="{{json_encode($menuConfig)}}"></site-menu>
    </header>

    <main>
        @yield('content')
    </main>

    <footer class="page-footer">
        <div class="footer-copyright">
            <div class="container">
                © {{date('Y')}} <a class="grey-text text-lighten-4" href="http://code.education">Code Education</a>
            </div>
        </div>
    </footer>
</div>

@stack('scripts')
<script src="{{asset('build/site.bundle.js')}}"></script>
</body>
</html>
