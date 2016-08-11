<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="garridodiaz.com">

    <title>EU VAT Validator, rate, calculator..</title>

    <!-- Bootstrap core CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/cover.css" rel="stylesheet">

   
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="site-wrapper">

      <div class="site-wrapper-inner">

        <div class="cover-container">

          <div class="masthead clearfix">
            <div class="inner">
              <h3 class="masthead-brand"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> EU VAT</h3>
              <nav>
                <ul class="nav masthead-nav">
                    <li class="active"><a href="/">Home</a></li>
                    <li><a href="https://github.com/neo22s/euvat/">Github</a></li>
                    <li><a href="https://github.com/neo22s/euvar/issues">Issues</a></li>
                    <li><a href="https://github.com/neo22s/euvat/blob/master/README.md">Readme</a></li>
                </ul>
              </nav>
            </div>
          </div>

        <div class="inner cover">
            <h1 class="cover-heading"><span class="glyphicon glyphicon-euro" aria-hidden="true"></span> EU VAT</h1>

            <p class="lead">Email Validator is a free JSON API that gives you a simple way to validate/verify email addresses. You can get the free <a href="https://github.com/neo22s/euvat/">source code and run it on your server</a> or use this service for free ;)</p>
            
            <p class="lead">
                <br>
                <form method="GET" class="form-inline">
                    <div class="form-group">
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                    </div>                    
                    <button type="submit" class="btn btn-lg btn-default">Verify!</button>
                </form>
                <br>
            </p>

            <p class="lead">
                <h3>How to use it?</h3>
                <code>index.php/?email=some@email.com</code><br>
                OR<br>
                <code>emailvalidator::check('some@email.com');</code><br>
                <h3>How works?</h3>
                1. checks Email Format/Syntax<br>
                2. checks MX-Records (SMTP)<br>
                3. checks for Disposable Addresses<br>
                4. returns JSON<br>
                <code>{"valid":true,"message":"chema@gmail.com"}</code><br>
                <code>{"valid":false,"message":"Banned domain sharklasers.com"}</code>
            <p>

        </div>


          <div class="mastfoot">
            <div class="inner">
              <p>Made by <a href="https://chema.ga.com">Chema</a> Thanks to <a href="https://github.com/ivolo/disposable-email-domains/">Disposable Emails</a></p>
            </div>
          </div>

        </div>

      </div>

    </div>

   
  </body>
</html>