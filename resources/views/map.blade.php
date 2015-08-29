<?php $positions = json_encode(App\User::getPositions()); ?>

<!DOCTYPE html>
<html>
    <head>
        <title>CL213 | Carte</title>
        <style type="text/css">
            html, body { height: 100%; margin: 0; padding: 0; }
            #map { height: 100%; }
        </style>
    </head>
    <body>
        @include('google.map')
    </body>
</html>