<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>MyVehicle | Greefi Technologies</title>
    <meta name="description" content="MyVehicle is One Stop Fleet Accounts Management Solution.To manage account for lorry.">
    <meta name="keywords" content="myvehicle,greefi technology,fleet finance management,sankari lorry owners association,tiruchengode lorry owners association">
    <meta name="author" content="Myvehicle INC">
    <script src="https://embed.small.chat/T432XN8QHG7CM1TEF5.js" async></script>
    <script>
        window.__pushpro = {
            site_uuid: "1f43eb66-a2bf-4959-bc43-0950b95afe25",
        }
    </script>
    <script src="https://storage.googleapis.com/push-pro-java-scripts/pushpro-lib.js"></script>
    <link rel="stylesheet" media="screen" href="{{ url('design/css/bootstrap.css') }}"/>
    <link rel="apple-touch-icon" sizes="57x57" href="{{ url('design/fav/apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ url('design/fav/apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ url('design/fav/apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ url('design/fav/apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ url('design/fav/apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ url('design/fav/apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ url('design/fav/apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ url('design/fav/apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ url('design/fav/apple-icon-180x180.png') }}">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ url('design/fav/android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ url('design/fav/favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ url('design/fav/favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ url('design/fav/favicon-16x16.png') }}">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,100,100italic,300,300italic,900italic,900,700italic,700,500italic,500,400italic' rel='stylesheet' type='text/css'>
    <!--
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.2/modernizr.js"></script>
     @if(env('APP_ENV') == 'production')
        <!-- Global site tag (gtag.js) - Google Analytics -->
        <script async src="https://www.googletagmanager.com/gtag/js?id=UA-92345002-2"></script>
        <script>
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());

          gtag('config', 'UA-92345002-2');
        </script>
    @endif

    <script type="text/javascript" src="{{ url('design/js/app.min8558.js') }}"> </script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->

</head>

<body data-spy="scroll"  data-target=".navbar"  id="homepage">
<nav class="navbar navbar-fixed-top" data-spy="affix" data-offset-top="768">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div id="response"></div>
        <div class="navbar-header hidden-vxs">
            <button type="button" class="navbar-toggle collapsed hide" data-toggle="collapse" data-target="#defaultNavbar1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            <a  class="navbar-brand hide-logo" href="#home"><img  src="{{ url('design/img/my_vehicle-logo.png') }}" title="MyVehicle" alt="MyVehicle" class="img-responsive" /> </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->

        <ul class="nav navbar-nav navbar-right">
            <li><a href="#home" class="active"><span class="hidden-xs">Home</span>
                    <span class="glyphicon glyphicon glyphicon-home visible-xs"></span></a></li>
            <li><a href="#about">About us</a></li>
            <li><a href="#contact">Contact us</a></li>
            <li><a href="{{ url('/roadmap') }}">Road Map</a></li>
        </ul>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>
<div class="hero" id="home">
    <div id='bblogin' class="login-form text-center white">
        <h1>MyVehicle - One Stop Fleet Accounts Management Solution</h1>
        <div class="text-center">
            <h2>Checkout Our Product as</h2>
            <a href="{{ url('/client/login') }}"><input type="submit" value="Owner" class="btn btn-lg" id="login-btn"></a>
            <a href="{{ url('/manager/login') }}"><input type="submit" value="Manager" class="btn  btn-lg" id="login-btn"></a>

            <p>&nbsp;Having any Trouble?</p>
            <p><a href="#"><span class="glyphicon glyphicon glyphicon-phone"></span>  + 91 90924 73334</a> &nbsp; <br class="visible-xs" />  &nbsp;
                <a href="#"><span class="glyphicon glyphicon glyphicon-envelope"> </span> hello@myvehicle.biz</a></p>
        </div>
    </div>
    <a href="#about" class="down"><span class="glyphicon glyphicon glyphicon-menu-down"></span></a>

    <div class="overlay"></div>
</div>
<div class="main">
    <section id="about" class="" style="background-color:#fff">
        <div class="container">
            <h1><span>About Us</span> </h1>
            <div class="row text-center"><br>
                <img src="{{ url('design/img/about.png') }}" class="img-responsive" alt="Managing Truck Accounts Simple & Effective"  title="Managing Truck Simple & Effective" />
            </div>
            <h1>Managing Truck Accounts <br class="visible-xs" />Simple &amp; Effective</h1>
            <div class="lead text-center"><p>Team of <a href="https://greefitech.com">Greefi Technologies</a> people working on vigorously to make the truck owners work simpler!</p>
            </div>
        </div>
    </section>
    <section id="contact" class="white">
        <div class="container">
            <h1 class="white"><span>Contact us </span></h1>
            <p class="lead text-center"> </p>
            <div class="row">

                <div class="col-md-6 col-md-offset-1 col-sm-6 ">
                    <h3>Let's have a &#9749; at our office</h3>
                </div>
                <div class="col-md-4 col-sm-6 text-right ">
                    <address>
                        <p> Greefi Technologies <br>
                            <span class="small">Room No : 9, First Floor, <br>
							Sri Shanmugha College of Engineering and Technology,<br>
							Sankari - Tiruchengode Main Road, Pullipalayam,<br> Sankari, Salem (Dt), Tamil Nadu - 637304.</span>
                        </p>
                        <p>Mail us
                            - <a href="#">hello@myvehicle.biz</a></p>
                        <p>Call us
                            - + 91 9092473334</p>
                        <em><small>© {{ date("Y") }} <a href="https://greefitech.com" target="_blank">Greefi Technologies</a> | <a href="terms" target="_blank" title="Terms Of Service">Terms Of Service</a> | <a href="privacy" target="_blank" title="Privacy Statement">Privacy Statement</a></small></em>
                    </address>
                </div>
            </div>
        </div>
        <footer>
            <div class="container">
                <div class="row text-right">
                </div>
            </div>
            <a href="#home" class="down"><span class="glyphicon glyphicon glyphicon-menu-up"></span></a>
        </footer>
    </section>
</div>
<div class="se-pre-con"></div>
<script>
    $(function() {
        layoutFix();
        $( window ).resize(function() {
            layoutFix();
        });
        $('[data-toggle="tooltip"]').tooltip();
        function layoutFix(){
            var heroHeight = $(window).height();
            var heroWidth = $(window).width();
            $('.hero').height(heroHeight);
            if (heroWidth > 319) {
                $('#homepage .main section').css('min-height', heroHeight);
                $('#homepage').attr('data-offset', heroHeight/3);
                $('#homepage .navbar').attr('data-offset-top', heroHeight-60);
                //data-target=".navbar" data-offset="768"
            }
        }
        $('.navbar a[href^="#"], a.down').on('click', function(event) {
            var target = $($(this).attr('href'));
            if (target.length) {
                event.preventDefault();
                $('html, body').animate({
                    scrollTop: target.offset().top
                }, 500);
            }
        });
        $('.hero').waitForImages(true).done(function(){
            $(".se-pre-con").fadeOut("slow");
        });
    });
</script>
</body>
</html>
