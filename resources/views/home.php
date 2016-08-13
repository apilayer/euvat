<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EU VAT , European VAT API, get company information, calculate rates, get rates, by ip">
    <meta name="author" content="chema.ga">

    <title>EU VAT - FREE European VAT API, validate VAT number, get company information, calculate rates, get rates by ip</title>

    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-4562297-29', 'auto');
      ga('send', 'pageview');

    </script>

    <!-- Bootstrap Core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <!-- Theme CSS -->
    <link href="css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-T8Gy5hrqNKT+hzMclPo118YTQO6cYprQmhrYwIiQ/3axmI1hQomh7Ud2hPOy8SP1" crossorigin="anonymous">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <link href="data:image/x-icon;base64,AAABAAEAEBAAAAAAAABoBAAAFgAAACgAAAAQAAAAIAAAAAEAIAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAP///wD///8A////AP///wD///8A////AP///wDr6+v/zs7O/729vf+9vb3/xcXF/+Li4v/5+fm/////AP///wD///8A////AP///wD///8A////AOrq6v+SgoL/XAkJ/24LC/+SCAj/fwgI/zUICP8+KCj/lJSU/9HR0f////8A////AP///wD///8A////AN3d3f9rEBD/qTo6/8hxcf/z8fH//v7+D////wD+/Pw/7tnZ/9Cenv9YUlL/19fX/////wD///8A////APLy8v+NDw//hhoa//f39+n///8A////AP///wD///8A////AP///wD///8A9erq//X19f////8A8/Pz/+bm5v+nPj7/axAQ/9zc3P/m5ub/5ubm/+bm5v/m5ub/5ubm//Ly8v////8A////AP///wD///8A////AE4WFv9CDQ3/pAAA/ywLC/9CDQ3/Qg0N/0INDf9CDQ3/Qg0N/0ENDf+enp7/+Pj4xv///wD///8A////AP///wD16ur/y6mp/3YEBP+8jo7/xJOT/8aUlP/GlJT/x5aW/8aUlP/GlJT/qpOT/+np6f////8A////AP///wD///8A/fr6f6oODv+kAAD/pQgI/6UICP+lCAj/pQgI/6UICP+lCAj/pQgI/0kQEP/Pz8//////AP///wD///8A////AP///wD///8A8eDg/6Wlpf/n5+f/////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wC+lJT/mZmZ/9DQ0P/4+PjG////AP///wD///8A////AP///wDm5ub/r6+v/+3t7f////8A////AP///wD///8A////AOfLy/87Kyv/kpKS/7CwsP/IyMj/yMjI/7y8vP+JeHj/ZxAQ/10bG//o6Oj/////AP///wD///8A////AP///wD///8A9urq796oqP+ACAj/aAgI/2sICP+cDw//ulBQ/7ZfX//5+fmf////AP///wD///8A////AP///wD///8A////AP///wD///8A////AP///wD8/PxU////AP///wD///8A////AP///wAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA//8AAP//AAD+AwAA+AEAAPBwAADh/AAAgA8AAIAHAACABwAAwAcAAOP/AADw+AAA+AAAAPwBAAD//wAA//8AAA==" rel="icon" type="image/x-icon" />

</head>

<body id="page-top" class="index">

    <!-- Navigation -->
    <nav id="mainNav" class="navbar navbar-default navbar-fixed-top navbar-custom">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header page-scroll">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
                </button>
                <a class="navbar-brand" href="#page-top"><i class="fa fa-euro"></i> EU VAT</a>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li class="hidden">
                        <a href="#page-top"></a>
                    </li>
                    <li class="page-scroll">
                        <a href="#api">API</a>
                    </li>
                    <li class="page-scroll">
                        <a href="#about">About</a>
                    </li>
                    <li><a href="rates.json">Rates</a></li>
                    <li><a href="/api/ip/detect">Detect</a></li>
                    <li><a href="https://github.com/neo22s/euvat/">Github</a></li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container-fluid -->
    </nav>

    <!-- Header -->
    <header>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="intro-text">
                        <span class="name">EU VAT Rates</span>
                        <hr class="star-light">
                        <span class="skills">Free API - Validate Number - Calculate Rates - And more! </span>
                        <br>
                        <br>
                        <form  class="form-inline">
                            <div class="form-group">
                                <input type="vatnumber" class="form-control" id="vatnumber" name="vatnumber" placeholder="VAT Number">
                            </div>                    
                            <button type="submit" id="submit" class="btn btn-lg btn-default" >Verify!</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Portfolio Grid Section -->
    <section id="api">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>API endpoints</h2>
                    <hr class="star-primary">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 text-center">
                <p>
                    Get company info <code>https://euvat.ga/api/info/VATNUMBER</code><br>
                    Validate VAT Number <code>https://euvat.ga/api/validate/VATNUMBER</code><br>
                    <a href="rates.json">Get all European VAT rates</a> <code>https://euvat.ga/rates.json</code><br>
                    Get rate for a specific country <code>https://euvat.ga/api/rate/COUNTRYCODE</code><br>
                    Is European country? <code>https://euvat.ga/api/iseu/COUNTRYCODE</code><br>
                    Get VAT by IP <code>https://euvat.ga/api/ip/IPADDRESS</code><br>
                    Get VAT by IP auto detect <code>https://euvat.ga/api/ip/detect</code><br>
                    Calculate amount to pay <code>https://euvat.ga/api/calc/COUNTRYCODE/AMOUNT</code><br>
                <br>
                Country code needs to be in ISO 3166-1 alpha-2, Example ES=Spain, DK=Denmark etc. List <a href="rates.json">here</a>
                </p>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="success" id="about">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 text-center">
                    <h2>About</h2>
                    <hr class="star-light">
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-lg-offset-2">
                    <p>With EU VAT API, you can validate EU VAT Numbers, get the rates, calculate the amount you need to charge and much more!.</p>
                </div>
                <div class="col-lg-4">
                    <p>If you are a Developer, you can use the API points or you can download the source code and run it on your server. All for FREE!                    </p>
                </div>
                <div class="col-lg-8 col-lg-offset-2 text-center">
                    <a href="https://github.com/neo22s/euvat/archive/master.zip" class="btn btn-lg btn-outline">
                        <i class="fa fa-download"></i> Download Code
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center">
        <div class="footer-above">
            <div class="container">
                <div class="row">
                    <div class="footer-col col-md-4">
                        <h3>The author</h3>
                        <p>Made by <a href="https://chema.ga">Chema</a></p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>Thanks to</h3>
                        <p>
                            <a href="https://yclas.com/">Yclas</a>
                            <a href="https://lumen.laravel.com/" rel="nofollow">Lumen</a>, 
                            <a href="https://euvatrates.com/" rel="nofollow">EU VAT Rates</a>, 
                            <a href="http://www.maxmind.com" rel="nofollow">Maxmind</a>, 
                            <a href="https://startbootstrap.com/" rel="nofollow">StartBootstrap</a>.
                        </p>
                    </div>
                    <div class="footer-col col-md-4">
                        <h3>About EU VAT and MOSS</h3>
                        <p>MOSS (Mini One Stop Shop). <a href="https://chema.ga/moss/">EU VAT compliance MOSS – Resources for PHP and more</a>.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-below">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        Copyright &copy; 2016<script>new Date().getFullYear()>2016&&document.write("-"+new Date().getFullYear());</script>, euvat.ga
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scroll to Top Button (Only visible on small and extra-small screen sizes) -->
    <div class="scroll-top page-scroll hidden-sm hidden-xs hidden-lg hidden-md">
        <a class="btn btn-primary" href="#page-top">
            <i class="fa fa-chevron-up"></i>
        </a>
    </div>

    <!-- jQuery -->
    <script src="https://cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

    <!-- Plugin JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.3/jquery.easing.min.js"></script>

    <!-- Theme JavaScript -->
    <script type="text/javascript">

        document.getElementById("submit").addEventListener("click", function(event){
            event.preventDefault();
            location.href = '/api/info/'+document.getElementById("vatnumber").value;
        });

        (function($) {
            "use strict"; // Start of use strict

            // jQuery for page scrolling feature - requires jQuery Easing plugin
            $('.page-scroll a').bind('click', function(event) {
                var $anchor = $(this);
                $('html, body').stop().animate({
                    scrollTop: ($($anchor.attr('href')).offset().top - 50)
                }, 1250, 'easeInOutExpo');
                event.preventDefault();
            });

            // Highlight the top nav as scrolling occurs
            $('body').scrollspy({
                target: '.navbar-fixed-top',
                offset: 51
            });

            // Closes the Responsive Menu on Menu Item Click
            $('.navbar-collapse ul li a:not(.dropdown-toggle)').click(function() {
                $('.navbar-toggle:visible').click();
            });

            // Offset for Main Navigation
            $('#mainNav').affix({
                offset: {
                    top: 100
                }
            })

        })(jQuery); // End of use strict
    </script>

</body>

</html>
