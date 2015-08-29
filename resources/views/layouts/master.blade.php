<!doctype html>
<html class="no-js" lang="fr">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, max-width=, initial-scale=1.0" />
        <title>CL213 | {{ $page_title or "Accueil" }}</title>
        <link rel="stylesheet" href="{{ URL::to('foundation-5.5.2/css/foundation.css') }}" />
        <link rel="stylesheet" href="{{ URL::to('template/master.css') }}" />

        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    </head>
    <body>
        <div class="container">
            <div id="header">
                @include('includes.topbar')
                @include('includes.header')
            </div>

            <div id="content">
                @if($errors->count())
                <div data-alert class="alert-box info" style="margin: 10px;">
                    {!! implode($errors->all(), '<br/>') !!}
                    <a href="#" class="close">&times;</a>
                </div>
                @endif

                @yield('content')
            </div>
        </div>


        <script src="{{ URL::to('foundation-5.5.2/js/vendor/modernizr.js') }}"></script>
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/jquery.js') }}"></script>
        <script src="{{ URL::to('foundation-5.5.2/js/foundation.min.js') }}"></script>
        
        <script>
            $(document).foundation();
        </script>
    </body>
</html>
