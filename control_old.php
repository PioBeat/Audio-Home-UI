<html>
    <head>
        <title>
            Audio home user interface for openwrt 
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="./simple-sidebar.css">
        <link href="dashboard.css" rel="stylesheet">
        <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>

        <style>
            .navbar-collapse.collapse {
                display: block!important;
            }

            .navbar-nav>li, .navbar-nav {
                float: left !important;
            }


            .navbar-nav.navbar-right:last-child {
                margin-right: -15px !important;
            }

            .navbar-right {
                float: right!important;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-inverse" style="margin-top: -70px;" role="navigation">
            <div class="container-fluid">
                <div class="">
                    <ul class="nav navbar-nav navbar-left">
                        <li><a class="navbar-brand" href="#">Audio home user interface for openwrt</a></li>
                        <li>
                            <button type="button" class="btn btn-primary navbar-form" data-toggle="offcanvas">Toggle nav</button>
                        </li>
                    </ul>	
                </div>
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <div class="navbar-form btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default" id="mp3-prev">Prev</button>
                                <button type="button" class="btn btn-default" id="mp3-next">Next</button>
                            </div>
                        </li>
                        <li>
                            <div class="navbar-form btn-group" role="group" aria-label="...">
                                <button type="button" class="btn btn-default" id="minus">---</button>
                                <button type="button" class="btn btn-default" id="mute">Mute</button>
                                <button type="button" class="btn btn-default"id="plus">+++</button>
                            </div>
                        </li>
                    </ul>	
                </div>
            </div>
        </nav>

        <div class="container-fluid">
            <div class="row row-offcanvas row-offcanvas-left">

                <div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar" role="navigation">
                    <ul class="list-group">
                        <li class="list-group-item" id="radio-opt"><h3>Radio</h3></li>
                        <div class="collapse in collapseRadio">
                            <li class="list-group-item">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-default" id="stream-start">Start</button>
                                    <button type="button" class="btn btn-default stop">Stop</button>
                                </div>
                            </li>
                        </div>

                        <li class="list-group-item" id="mp3-opt"><h3 >MP3</h3></li>
                        <div class="collapseMp3 collapse">
                            <li class="list-group-item">
                                <div class="btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-default" id="mp3-start">Start</button>
                                    <button type="button" class="btn btn-default stop">Stop</button>
                                </div>
                            </li>
                        </div>


                    </ul>
                </div>
                <div class="col-xs-12 col-sm-9 content">
                    <div class="panel panel-default">
                        <div id="current-playing" class="panel-body">

                        </div>
                    </div>

                    <div class="text-center">
                        <h1>Radio</h1>
                        <div id="stream-list">

                        </div>
                    </div>

                    <div class="text-center">
                        <h1>MP3</h1>
                        <div id="mp3list">

                        </div>
                    </div>

                </div><!--/span-->

            </div><!--/row-->

        </div><!-- /.container -->
        <script type="text/javascript">
            $(function () {
                var endpointurl = "./endpoint/logic.php";

                getCurrentPlaying();
                $.post(endpointurl, {'action': 'mp3list'}, function (x) {
                    showMP3List(JSON.parse(x));
                });
                $.post(endpointurl, {'action': 'liststreams'}, function (x) {
                    showStreamList(JSON.parse(x));
                    getCurrentPlaying();
                });

                $("#radio-opt").click(function () {
                    $(".collapseRadio").collapse('show');
                    $(".collapseMp3").collapse('hide');

                });

                function getCurrentPlaying() {
                    $.post(endpointurl, {'action': 'current-playing'}, function (x) {
                        console.log(x);
                        d3.select("#current-playing").html(x).transition();
                    });

                }
                function showStreamList(input) {
                    console.log(input);
                    d3.select("#stream-list").append("ul")
                            .attr("class", "list-group").selectAll("li")
                            .data(input).enter()
                            .append("li")
                            .attr("class", "list-group-item").html(function (d, i) {
                        return d;
                    }).on('click', function (d, i) {
                        console.log("clicked on " + d + " index=" + i);
                        $.post(endpointurl, {'action': 'playspecific', 'index': i}, function (x) {
                            console.log(x);
                            getCurrentPlaying();
                        });
                    }).transition().styleTween("background-color", function () {
                        return d3.interpolate("grey", "white");
                    }).delay(function (d, i) {
                        return i * 50
                    })
                }

                function showMP3List(input) {
                    console.log(input);
                    d3.select("#mp3list")
                            .append("ul")
                            .attr("class", "list-group").selectAll("li")
                            .data(input).enter()
                            .append("li")
                            .attr("class", "list-group-item").html(function (d, i) {
                        return d;
                    }).on('click', function (d, i) {
                        console.log("clicked on " + d + " index=" + i);
                        $.post(endpointurl, {'action': 'playspecific', 'index': i}, function (x) {
                            console.log(x);
                            getCurrentPlaying();
                        });
                    }).transition().styleTween("background-color", function () {
                        return d3.interpolate("grey", "white");
                    }).delay(function (d, i) {
                        return i * 50
                    });
                }


                $("#mp3-opt").click(function () {
                    $(".collapseRadio").collapse('hide');
                    $(".collapseMp3").collapse('show');
                });

                $("#mp3-start").click(function () {
                    $.post(endpointurl, {'action': 'mp3-play'}, function (x) {
                        getCurrentPlaying();
                    });

                });
                $("#mp3-stop").click(function () {
                    $.post(endpointurl, {'action': 'mp3-stop'});
                });
                $("#mp3-prev").click(function () {
                    $.post(endpointurl, {'action': 'mp3-prev'});
                    getCurrentPlaying();
                });
                $("#mp3-next").click(function () {
                    $.post(endpointurl, {'action': 'mp3-next'});
                    getCurrentPlaying();
                });

                $("#menu-toggle").click(function (e) {
                    e.preventDefault();
                    console.log("toggle");
                    //$("#wrapper").toggleClass("toggled");
                    $(".sidebar").toggleClass("toggled");
                });
                $('[data-toggle=offcanvas]').click(function () {
                    if ($('.sidebar-offcanvas').css('background-color') == 'rgb(255, 255, 255)') {
                        $('.list-group-item').attr('tabindex', '-1');
                    } else {
                        $('.list-group-item').attr('tabindex', '');
                    }
                    $('.row-offcanvas').toggleClass('active');

                });

                $('#plus').click(function () {
                    console.log("sound louder");
                    $.post(endpointurl, {'action': 'plus'}, function (x) {
                        console.log($.trim(x));
                    });
                });
                $('#minus').click(function () {
                    console.log("sound leiser");
                    $.post(endpointurl, {'action': 'minus'}, function (x) {
                        console.log($.trim(x));
                    });
                });
                $('#mute').click(function () {
                    console.log("sound mute");
                    $.post(endpointurl, {'action': 'mute'}, function (x) {
                        console.log($.trim(x));
                    });
                });

                $('#stream-start').click(function () {
                    console.log("stream start");
                    $.post(endpointurl, {'action': 'stream-start'}, function (x) {
                        console.log($.trim(x));
                        getCurrentPlaying();
                    });
                });
                $('.stop').click(function () {
                    console.log("sound stop");
                    $.post(endpointurl, {'action': 'stop'}, function (x) {
                        console.log($.trim(x));
                    });
                });
            });
        </script>
    </body>
</html>