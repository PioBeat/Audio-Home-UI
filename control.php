<html>
    <head>
        <title>
            Audio home user interface for openwrt 
        </title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" type="text/css">
        <link rel="stylesheet" href="dashboard.css" type="text/css">
        <script src="http://d3js.org/d3.v3.min.js" charset="utf-8"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js" type="text/javascript"></script>
        <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js" type="text/javascript"></script>
    </head>
    <body>
        <nav class="navbar navbar-default navbar-inverse navbar-fixed-top" role="navigation">
            <div class="navbar-header">

                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span>
                </button> <a class="navbar-brand" href="#">AH user interface</a>
            </div>

            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
<!--                <ul class="nav navbar-nav">
                    <li class="active">
                        <a href="#">Link</a>
                    </li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="#">Link</a>
                    </li>
                </ul>-->
            </div>

        </nav>

        <div class="container-fluid">
            <!-- current playing-->
            <div class="row">
                <div class="col-xs-12 col-md-12 content">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                currently playing
                            </h3>
                        </div>
                        <div id="current-playing" class="panel-body">

                        </div>
                    </div>
                </div>
            </div>

            <!-- sound sources -->
            <div class="row">
                <div class="col-md-12">
                    <div class="tabbable tabs-left">
                        <ul class="nav nav-tabs">
                            <li class="active">
                                <a href="#radio-tab" data-toggle="tab">Radio</a>
                            </li>
                            <li>
                                <a href="#mp3-tab" data-toggle="tab">MP3</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="radio-tab">
                                <div class="clearfix">
                                    <button type="button" class="btn btn-default pull-left" id="btn-add-stream"
                                            href="#modal-container-stream-add" role="button" data-toggle="modal">
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> add radio stream
                                    </button>
                                    <div class="btn-group pull-right" style="margin-left: 12px;" role="group" aria-label="...">
                                        <button type="button" class="btn btn-default" id="stream-start">Start</button>
                                        <button type="button" class="btn btn-default stop">Stop</button>
                                    </div>
                                    <span class="inline pull-right"><h4>Radio</h4></span>
                                </div>

                                <div id="stream-list">

                                </div>

                            </div>
                            <div class="tab-pane fade" id="mp3-tab">
                                <div class="clearfix">
                                    <div class="btn-group pull-right" style="margin-left: 12px;" role="group" aria-label="...">
                                        <button type="button" class="btn btn-default" id="mp3-start">Start</button>
                                        <button type="button" class="btn btn-default stop">Stop</button>
                                    </div>
                                    <span class="inline pull-right"><h4>MP3</h4></span>
                                </div>

                                <div id="mp3list">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <hr/>
            <!-- control panel -->
            <div class="row">
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Music control
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="text-center">
                                <div class="navbar-form btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-default btn-lg" id="mp3-prev">Prev</button>
                                    <button type="button" class="btn btn-default btn-lg" id="mp3-next">Next</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Sound control
                            </h3>
                        </div>
                        <div class="panel-body"> 
                            <div class="text-center">
                                <div class="navbar-form btn-group" role="group" aria-label="...">
                                    <button type="button" class="btn btn-default btn-lg" id="minus">---</button>
                                    <button type="button" class="btn btn-default btn-lg" id="mute">Mute</button>
                                    <button type="button" class="btn btn-default btn-lg" id="plus">+++</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modal-container-stream-add" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                            ×
                        </button>
                        <h4 class="modal-title" id="myModalLabel">
                            Add radio stream
                        </h4>
                    </div>
                    <div class="modal-body">
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">Name</span>
                            <input type="text" class="form-control" placeholder="link" id="input-stream-name">
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon" id="basic-addon1">URL</span>
                            <input type="text" class="form-control" placeholder="link" id="input-stream-link">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            Close
                        </button> 
                        <button id="btn-save-stream" type="button" class="btn btn-primary">
                            Save
                        </button>
                    </div>
                </div>

            </div>

        </div>


        <script type="text/javascript">
            $(function () {
                var endpointurl = "./endpoint/logic.php";

                getCurrentPlaying();
                addRadioStreamList();
                $.post(endpointurl, {'action': 'mp3list'}, function (x) {
                    showMP3List(JSON.parse(x));
                });
                
                function addRadioStreamList() {
                    $.post(endpointurl, {'action': 'liststreams'}, function (x) {
                        showStreamList(JSON.parse(x));
                        getCurrentPlaying();
                    });
                }
                function refreshRadioStreamList() {
                    $.post(endpointurl, {'action': 'liststreams'}, function (x) {
                        updateStreamList(JSON.parse(x));
                        getCurrentPlaying();
                    });
                }

                $("#radio-opt").click(function () {
                    $(".collapseRadio").collapse('show');
                    $(".collapseMp3").collapse('hide');

                });

//                $('#modal-container-stream-add').on('hidden.bs.modal', function () {
//                    window.alert('hidden event fired!');
//                  });

                $('#btn-save-stream').click(function () {
                    var link = $('#input-stream-link').val();
                    var name = $('#input-stream-name').val();
//                    http://stream2.jungletrain.net:8000/
                    console.log("Link ", link, $('#input-stream-link'));
                    $.post(endpointurl, {'action': 'add-radio-stream', 'name': name, 'link': link}, function (x) {
                        console.log(x);
                        $('#modal-container-stream-add').modal('hide');
                        updateStreamList(JSON.parse(x));
                    });
                });

                function getCurrentPlaying() {
                    $.post(endpointurl, {'action': 'current-playing'}, function (x) {
                        console.log(x);
                        d3.select("#current-playing").html(x).transition();
                    });

                }
                var streamlist;
                
                /**
                 * adds the stream list of possible radio streams to the site
                 * @param {type} input
                 * @returns {undefined}
                 */
                function showStreamList(input) {
                    console.log(input);
                    streamlist = d3.select("#stream-list").append("ul")
                            .attr("class", "list-group").selectAll("li")
                            .data(input);
                    
                    var sc = streamlist.enter().append("li")
                            .attr("class", "list-group-item").html(function (d, i) {
                        console.log("stream", d, i);
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
                    streamlist.exit();
                }
                
                /**
                 * Updates the stream list after a new one is added
                 * @param {type} newentry
                 * @returns {undefined}
                 */
                function updateStreamList(newentry) {
                    console.log("newentry", newentry);
                    var selection = d3.select("#stream-list").select("ul").selectAll("li").data(newentry);
                    selection.enter()
                            .append("li")
                            .attr("class", "list-group-item").html(function (d, i) {
                                console.log("stream", d, i);
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
                            selection.exit().remove();//remove also, if one stream is deleted, old entries should not be there
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
                        refreshRadioStreamList();
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