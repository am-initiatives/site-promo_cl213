<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CL213 | Connexion</title>
        <link rel="stylesheet" href="{{ URL::to('foundation-5.5.2/css/foundation.css') }}" />
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/modernizr.js') }}"></script>
    </head>
    <body>

        <div class="row" style="padding-top: 10%">
            <div class="small-6 small-offset-3 columns">
                <div class="callout panel">
                    @yield('content')
                </div>
            </div>
        </div>
        
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/jquery.js') }}"></script>
        <script src="{{ URL::to('foundation-5.5.2/js/foundation.min.js') }}"></script>
        <script>
            $(document).foundation();
        </script>
    </body>
</html>
