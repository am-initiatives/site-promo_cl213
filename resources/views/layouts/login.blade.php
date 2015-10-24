<!doctype html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>CL213 | Connexion</title>
        <link rel="stylesheet" href="{{ URL::to('foundation-5.5.2/css/foundation.css') }}" />
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/modernizr.js') }}"></script>
    </head>
    <style type="text/css">
        body {
            background: url("{{ URL::to('login-background.jpg') }}") no-repeat bottom center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        #login-panel {
            box-shadow: 0px 0px 10px 0px rgba(50, 50, 50, 0.2);
        }
    </style>
    <body>
        <div id="login-advice" style="text-align: center; display: none;"><button class="medium radius button">Connexion</button></div>
        <div class="row" style="padding-top: 10%">
            <div class="large-6 medium-8 large-offset-3 medium-offset-2 columns">
                <div id="login-panel" class="panel">
                    <a id="login-hide" class="show-for-medium-up" style="display: block; text-align: right; margin-top: -18px; margin-right: -10px;">&times;</a>
                    @yield('content')
                </div>
                @if (count($errors) > 0)
                    <div class="panel">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>
        </div>
        
        <script src="{{ URL::to('foundation-5.5.2/js/vendor/jquery.js') }}"></script>
        <script src="{{ URL::to('foundation-5.5.2/js/foundation.min.js') }}"></script>
        <script>
            $(document).foundation();
            $(document).ready(function() {
                $("input, button").focus(function() {
                    $("#login-panel").fadeTo("slow", 1);
                    $("#login-advice").hide("slow");
                });

                $("#login-hide").click(function() {
                    $("#login-panel").fadeTo("slow", 0);
                    $("#login-advice").show("slow");
                });

                $(document).keyup(function(evt) {
                    if (evt.keyCode == 27) {
                        if ($("#login-advice").is(":visible")) {
                            $("#login-panel").fadeTo("slow", 1);
                            $("#login-advice").hide("slow");
                        }
                        else {
                            $("#login-panel").fadeTo("slow", 0);
                            $("#login-advice").show("slow");
                        }
                    }
                });
            });
        </script>
    </body>
</html>
