<?php $positions = json_encode(App\User::getPositions()); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>CL213 | Carte</title>

        <link rel="stylesheet" href="{{ url('foundation-5.5.2/css/foundation.css') }}" />
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

        <style type="text/css">
            html, body { height: 100%; margin: 0; padding: 0; }
            #map { height: 100%; }
        </style>
    </head>
    <body>
        <nav class="top-bar" data-topbar role="navigation">
            <section class="top-bar-section">
                <!-- Right Nav Section -->
                <ul class="right">
                    <li><a href="#" onclick="$('nav').hide()">Cacher cette barre</a></li>
                </ul>


                <!-- Left Nav Section -->
                <ul class="left">
                    <li><a href="{{ route('home') }}"><i class="fa fa-chevron-left"></i> Revenir sur le site</a></li>
                </ul>
            </section>
        </nav>
        @include('google.map')

        <script src="{{ URL::to('foundation-5.5.2/js/vendor/jquery.js') }}"></script>
    </body>
</html>