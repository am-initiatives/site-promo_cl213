<!doctype html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CL213 | Configuration</title>
        <link rel="stylesheet" href="{{ URL::to('foundation-5.5.2/css/foundation.css') }}" />
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/modernizr.js') }}"></script>
    </head>
    <link rel="stylesheet" href="{{ URL::to('template/config.css') }}" />
    <body>
        @yield('content')
        
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/jquery.js') }}"></script>
        <script src="{{ URL::to('foundation-5.5.2/js/foundation.min.js') }}"></script>
        <script>
            $(document).foundation();
        </script>
        @yield('scripts')
    </body>
</html>
