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
    <link href="{{asset('css/admin.css')}}" rel="stylesheet">

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
            @if (Auth::check())
                <?php
                $menuConfig = [
                        'name' => Auth::user()->name,
                        'urlLogout' => env('URL_ADMIN_LOGOUT'),
                        'csrfToken' => csrf_token(),
                        'menus' => [
                                ['name'=>'Contas a pagar','url'=>"/teste",'dropdownId'=>'teste'],
                                ['name'=>'Contas a receber','url'=>"/teste1"],
                        ],
                        'menusDropdown' => [
                                [
                                        'id' => 'teste',
                                        'items' => [
                                                ['name'=>"Listar contas",'url'=>'/listar'],
                                                ['name'=>"Criar contas",'url'=>'/criar'],
                                        ]
                                ]
                        ],
                ];
                ?>
                <admin-menu :config="{{json_encode($menuConfig)}}"></admin-menu>
            @endif
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

    <!-- Scripts -->
    <script src="{{asset('build/admin.bundle.js')}}"></script>
</body>
</html>
