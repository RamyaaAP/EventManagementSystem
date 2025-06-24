<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CEG EVENTS</title>
    <link rel = "stylesheet" type = "text/css" href = "css/bootstrap.css">
<link rel = "stylesheet" type = "text/css" href = "css/style.css"> <!-- Include CSS links from utils/styles.php -->

</head>

<body>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>CEG EVENTS</title>
    <style>
        .bgImage {
            background-image: url('images/slider_ceg.jpg');
            background-size: cover;
            background-position: center center;
            height: 100vh;
            margin-bottom: 25px;
        }
    </style>
</head>
<body>
    <header class="bgImage">
        <nav class="navbar">
            <div class="container">
                <div class="navbar-header"><!--website name/title-->
                    <a class="navbar-brand">
                    <h2>CEG EVENTS</h2>
                    </a>
                    
                </div>
                <ul class="nav navbar-nav navbar-right"><!--navigation-->
                    <li><a href="./index.php"><strong>Home</strong></a></li>
                    <li><a href="./profile.php"><strong>Profile</strong></a></li>
                    <li><a href="./usn.php"><strong>Login/Register</strong></a></li>
                    <li><a href="./contact.php"><strong>Contact Us</strong></a></li>
                    <li><a href="./aboutus.php"><strong>About Us</strong></a></li>
                    <li class="btnlogout"><a class="btn btn-default navbar-btn" href="./login_form.php">Admin Login <span class="glyphicon glyphicon-log-in"></span></a></li>
                </ul>
                
            </div><!--container div-->
        </nav>
        <!-- Search Form -->
        <div class="container">
                <form action="searchResult.php" method="GET" class="navbar-form navbar-right">
                    <div class="form-group">
                        <input type="text" name="search" class="form-control" placeholder="Search for Events">
                    </div>
                    <button type="submit" class="btn btn-primary">Search</button>
                </form>
            </div>
    </header>
</body>
</html>
 <!-- Include header content from utils/header.php -->
    <div class="content"><!-- Body content holder -->
        <div class="container">
            <div class="col-md-12"><!-- Body content title holder with 12 grid columns -->
                <h1 style="color:#000080; font-size:42px; font-weight:bold;">REGISTER YOUR FAVORITE EVENTS</h1><!-- Body content title -->
            </div>

            <!-- Dynamic Categories Section -->
                            <div class="container">
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <section>
                        <div class="container">
                            <div class="col-md-6">
                                <img src="images/Movie-1.png" class="img-responsive">
                            </div>
                            <div class="subcontent col-md-6">
                                <h1 style="color:#003300; font-size:38px;"><u><strong>Gaming Events</strong></u></h1>
                                <p>
                                    EMBRACE YOUR GAMING SKILLS BY PARTICIPATING IN OUR DIFFERENT GAMING EVENTS!
                                </p>
                                <br><br>
                                <!-- Link to view events of a specific category -->
                                <a class="btn btn-default" href="viewEvent.php?category=Gaming">
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span> View Gaming Events
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
                            <div class="container">
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <section>
                        <div class="container">
                            <div class="col-md-6">
                                <img src="images/computer.jpg" class="img-responsive">
                            </div>
                            <div class="subcontent col-md-6">
                                <h1 style="color:#003300; font-size:38px;"><u><strong>Technical Events</strong></u></h1>
                                <p>
                                    EMBRACE YOUR TECHNICAL SKILLS BY PARTICIPATING IN OUR DIFFERENT TECHNICAL EVENTS!
                                </p>
                                <br><br>
                                <!-- Link to view events of a specific category -->
                                <a class="btn btn-default" href="viewEvent.php?category=Technical">
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span> View Technical Events
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
                            <div class="container">
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <section>
                        <div class="container">
                            <div class="col-md-6">
                                <img src="images/agni.jpg" class="img-responsive">
                            </div>
                            <div class="subcontent col-md-6">
                                <h1 style="color:#003300; font-size:38px;"><u><strong>On-Stage Events</strong></u></h1>
                                <p>
                                    EMBRACE YOUR ON-STAGE SKILLS BY PARTICIPATING IN OUR DIFFERENT ON-STAGE EVENTS!
                                </p>
                                <br><br>
                                <!-- Link to view events of a specific category -->
                                <a class="btn btn-default" href="viewEvent.php?category=On-Stage">
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span> View On-Stage Events
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
                            <div class="container">
                    <div class="col-md-12">
                        <hr>
                    </div>
                </div>

                <div class="row">
                    <section>
                        <div class="container">
                            <div class="col-md-6">
                                <img src="images/sportcw.jpg" class="img-responsive" size="50%">
                            </div>
                            <div class="subcontent col-md-6">
                                <h1 style="color:#003300; font-size:38px;"><u><strong>Sport Events</strong></u></h1>
                                <p>
                                    EMBRACE YOUR SPORTS SKILLS BY PARTICIPATING IN OUR DIFFERENT SPORT EVENTS!
                                </p>
                                <br><br>
                                <!-- Link to view events of a specific category -->
                                <a class="btn btn-default" href="viewEvent.php?category=Off-Stage">
                                    <span class="glyphicon glyphicon-circle-arrow-right"></span> View Sport Events
                                </a>
                            </div>
                        </div>
                    </section>
                </div>
            
        </div><!-- End of body content container -->

        <hr class="footerline"><!--css modified horizontal line-->
<footer>
    <div class="container">
        <h5 style="text-align: center;">&copy; 2024 BY: N K R</h5>
        <br>
    </div>
</footer>
 <!-- Include footer content from utils/footer.php -->
    </div><!-- End of body content -->

</body>

</html>
