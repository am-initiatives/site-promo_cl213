<!doctype html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, max-width=, initial-scale=1.0" />
        <title>CL213 | Acceuil</title>
        <link rel="stylesheet" href="{{ URL::to('template/cl213.css') }}" />
        <link rel="stylesheet" href="{{ URL::to('foundation-5.5.2/css/foundation.css') }}" />
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/modernizr.js') }}"></script>
    </head>
    <body>

        <div class="container">
            <div id="header">
                @include('includes.topbar')
                @include('includes.header')
            </div>

            <div id="content">
                @yield('content')
            </div>
        </div>
        
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/jquery.js') }}"></script>
        <script src="{{ URL::to('foundation-5.5.2/js/foundation.min.js') }}"></script>
        <script>
            $(document).foundation();
        </script>
    </body>
</html>
