<?php

    // Check login status:
    include("php_includes/check_login_status.php");

    // If user is logged in, no need to login:
    if($user_ok == true){
        $username = $_SESSION['username'];
    }

    // If user attempts to log in:
    if(isset($_POST["e"])){

        // Connect to DB:
        include_once("php_includes/db_conx.php");

        // Gather posted data and sanatize:
        $e = mysqli_real_escape_string($db_conx, $_POST['e']);
        $p = md5($_POST['p']);

        // User's IP Address:
        $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

        // Form data error handling (if username or password are blank):
        if($e == "" || $p == ""){
            header('location:login.php');
        }

        else {

            // Proceed to processing username and password:
            $sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
            $row = mysqli_fetch_row($query);

            $db_id = $row[0];
            $db_username = $row[1];
            $db_pass_str = $row[2];

            // If password doesn't match, boot them away:
            if($p != $db_pass_str){
                header('location:login.php');
            }

            else {
                // Else... create new session and cookies:
                $_SESSION['userid'] = $db_id;
                $_SESSION['username'] = $db_username;
                $_SESSION['password'] = $db_pass_str;
                setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
                setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
                setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);

                // Update to their current IP address and login date:
                $sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
                $query = mysqli_query($db_conx, $sql);
                echo $db_username;

                // Bring them to their dashboard:
                header('location:users.php?u=' . $db_username);
            }
        }
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en" >
<head>

    <!-- Responsiveness -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="media/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="media/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="media/favicon/favicon-16x16.png">
    <link rel="manifest" href="media/favicon/site.webmanifest">
    <link rel="mask-icon" href="media/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#00aba9">
    <meta name="theme-color" content="#ffffff">

    <!-- Search Engine Optimization (SEO) / Google Analytics:

    NEED TO ADD CONTENT HERE!!

    -->

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>


    <!-- Title -->
    <title> Repaw | Foster   </title>

    <!-- BootStrap 4 -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <!-- Slick Carousel -->
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.5.5/slick.min.css'>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>

    <!-- Local stylesheets -->
    <link rel="stylesheet" href="style/foster.css">
    <link rel="stylesheet" href="style/footer.css">

</head>

<script>

$(document).ready(function() {
  $('#modal').on('show.bs.modal', function(e) {
    var id = $(e.relatedTarget).data('id');
    alert(id);
  });
});

</script>

<body>

    <!-- Main Image -->
    <div class="top-container"> </div>

    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">

        <!-- Navbar logo -->
        <a class="navbar-brand" href="index.php">
            <img src="media/index/nav_logo3.png" height="30px" width="30px">
        </a>

        <!-- BootStrap mobile view -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Desktop view -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="nav nav-tabs mr-auto">
                <li class="nav-item active">
                    <a class="nav-link active">Foster Care</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">API Services</a>
                </li>
            </ul>

            <?php
                // If user is logged in (don't display login information):
                if($user_ok == true){
                    echo '<b>Welcome ' . $username . '</b>&nbsp; &nbsp;';
                    echo '
                        <a class="btn btn-sm btn-outline-secondary nav-btn" href="users.php?u=' . $_SESSION["username"] . '" role="button">Profile</a> &nbsp;
                        <a class="btn btn-sm btn-outline-secondary nav-btn logout-btn" href="logout.php"> Logout </a>
                    ';
                }

                else {
                    // If user isn't logged in, provide them with the option to login or sign up:
                    echo '
                    <form class="form-inline my-2 my-lg-0" method="post">
                        <input class="form-control mr-sm-2" type="text" placeholder="Email" id="e" name="e">
                        <input class="form-control mr-sm-2" type="password" placeholder="Password" id="p" name="p">
                        <button class="btn btn-sm btn-outline-secondary nav-btn" type="submit">Login</button> &nbsp;
                        <a href="signup.php" class="btn btn-sm btn-outline-secondary nav-btn">Signup</a> &nbsp;
                        <a href="login.php" class="btn btn-sm btn-outline-secondary nav-btn demo">Demo</a>

                    </form>';
                }
            ?>
        </div>
    </nav> <!-- Closing navbar -->

    <!-- Main body content -->
    <div class="container-fluid">
        <div class="row row-content">
            <div class="col-lg-3 form-col">
                <div class='info-form'>

                    <form method="post" action="rescue_results.php" id='fosterForm'>

                        <br>

                        <i class="fas fa-dog"></i>



                        <div class='icon-container'>
                            <label>
                                <input type="radio" id="Dog" value="1" name="type" checked="">
                                <img class='icon' src="media/foster/dog-solid.svg" height="75px" width="75px">
                            </label>

                            <label>
                                <input class='icon-cat' type="radio" id="Cat" value="2" name="type">
                                <img class='icon icon-cat' src="media/foster/cat-solid.svg" height="75px" width="75px">
                            </label>

                            <div class='choose bold'> Select Type </div>
                        </div>

                        <br>

                        <label class='label bold' for="gender">Gender</label>
                        <select class="custom-select my-1 mr-sm-2" id="gender" name="gender" required>
                            <option value=""></option>
                            <option value='Either'> No Preference </option>
                            <option value="Male">Male</option>
                            <option value="Female">Female </option>
                        </select>

                        <br>

                        <label class='label bold' for="age">Age</label>
                        <select class="custom-select my-1 mr-sm-2" id="age" name="age" required>
                            <option value=""></option>
                            <option value='Either'> No Preference </option>
                            <option value="Young">Young</option>
                            <option value="Teen">Teen</option>
                            <option value="Adult">Adult</option>
                            <option value="Senior">Senior</option>
                        </select>

                        <label class='label bold' for="size">Size</label>
                        <select class="custom-select my-1 mr-sm-2" id="size" name="size" required>
                            <option value=""></option>
                            <option value='Either'> No Preference </option>
                            <option value="XSmall">Extra Small</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="XLarge">Extra Large</option>
                        </select>

                        <label class='label bold' for="zipcode">Location</label>
                        <input class="form-control" id="zipcode" name="zipcode" type="text" maxlength="5" placeholder='Zipcode' onchange="getInfo(this.value)"><br>
                        <input class="form-control" id="city" name="city" type="text" placeholder='City' readonly><br>
                        <input class="form-control" id="state" name="state" type="text" placeholder='State' readonly><br>

                        <label class='label bold' for='distance_from_zip'> Distance </label>
                        <select class="custom-select my-1 mr-sm-2" id="distance_from_zip" name="distance_from_zip">
                            <option value=""></option>
                            <option value="3000"> Any </option>
                            <option value="1">1 Mile</option>
                            <option value="5">5 Miles</option>
                            <option value="10">10 Miles</option>
                            <option value="25">25 Miles</option>
                            <option value="50">50 Miles</option>
                        </select>

                        <br> <br>
                        <!-- Submit button -->
                        <button type="submit" name="search" class="btn btn-sm btn-outline-secondary nav-btn foster-form-btn">Submit</button>
                        <a class="btn btn-sm btn-outline-secondary nav-btn reset-btn foster-form-btn" onclick="resetForm()">Reset</a>
                    </form>
                </div> <!-- Close info-form -->
            </div> <!-- Close col-3 -->

            <!-- Card Column -->
            <div class="col-lg-9 card-col" >

                <div class="body-container rounded">

                    <h1 class="foster-header center"> Available Pets</h1>

                    <br>

                    <div class="container-fluid">
                        <div class="row">

                        <?php

                        // Pet Information:
                        $sql = "SELECT pet_adopt.id, pet_adopt.name, pet_adopt.age, pet_adopt.gender, pet_adopt.breed, pet_adopt.color, pet_adopt.hair, pet_adopt.size, pet_adopt.zip, pet_adopt.city, pet_adopt.state, pet_adopt.duration, pet_adopt.avail, pet_adopt.duration, pet_adopt.description, pet_adopt.image, usersmeta.company
                                FROM pet_adopt
                                INNER JOIN usersmeta ON pet_adopt.uid=usersmeta.uid LIMIT 6";
                        $query = mysqli_query($db_conx, $sql);

                        while($row = mysqli_fetch_array($query)) {

                          echo '
                          <div class="col-md-4 card-wrapper">
                              <div class="card shadow p-3 mb-5 bg-white rounded dash-card">

                                  <div class="card-header">'
                                      .$row['name'].
                                  '</div>
                                  <br>

                                  <div class="card-img-wrapper">
                                      <div class="card-img">
                                          <img src="orgs/upload/' . $row['image']. '" height="120px" width="150px" />
                                      </div>
                                  </div>
                                  <br>
                                  <br>

                                  <div class="card-info">
                                      <span id="bold">Age: </span> ' . $row['age'] . '
                                  </div>

                                  <div class="card-info">
                                      <span id="bold">Gender: </span> ' . $row['gender'] . '
                                  </div>

                                  <div class="card-info">
                                      <span id="bold">Size: </span> ' . $row['size'] . '
                                  </div>
                                  <div class="card-info">
                                      <span id="bold">Available: </span> ' .$row['avail']. ' (' . $row['duration'] . ')
                                  </div>
                                  <div class="card-info">
                                    <span id="bold"> Location: </span> '. $row['company'] . ' (' . $row['city'] . ', ' . $row['state'] . ')
                                  </div>

                                  <div class="card-footer text-center">
                                    <a class="btn btn-info btn-xs in-line card-btn" href="fetch_info.php?pet=' . $row['id']. '" data-target="#theModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">More Information</a>
                                  </div>

                              </div>
                          </div>
                          ';

                        }
                    ?>
                    </div>
                    </div> <!-- Close row -->
                </div> <!-- Close container -->
            </div> <!-- Close body-container -->

            <!-- ================================================== FOOTER ======================================================= -->

            <div class="site-footer" style='padding: 2vh 5vw 2vh 5vw'>
                <div class="container-fluid" >
                    <div class="row">
                        <div class="col-sm-12 col-md-6">
                            <h6>About</h6>
                            <p class="text-justify">Repawsitory is a completely free online platform built to help provide exposure for the 6.5 million cats and dogs 
                            circulating through shelters every year. Eligable pet foster parents can use our searchable database to find the perfect foster companion 
                            in their area and connect directly with the rescue or organization that houses them to arrange foster care. </p>
                        </div>

                        <div class="col-xs-6 col-md-3">
                            <h6>Categories</h6>
                            <ul class="footer-links">
                                <li><a href="foster.php">Foster Care</a></li>
                                <li><a href="api-services.php">API Services</a></li>
                            </ul>
                        </div>

                        <div class="col-xs-6 col-md-3">
                            <h6>Quick Links</h6>
                            <ul class="footer-links">
                                <li><a href="login.php">Login</a></li>
                                <li><a href="signup.php">Signup</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row">
                <div class="col-md-8 col-sm-6 col-xs-12">
                    <p class="copyright-text" style='color: #737373'>
                        Copyright &copy; 2019
                    </p>
                </div>

                <div class="col-md-4 col-sm-6 col-xs-12">
                    <ul class="social-icons">
                    <li><a class="facebook" href="#"><i class="fa fa-facebook"></i></a></li>
                    <li><a class="twitter" href="#"><i class="fa fa-twitter"></i></a></li>
                    <li><a class="dribbble" href="#"><i class="fa fa-dribbble"></i></a></li>
                    <li><a class="linkedin" href="#"><i class="fa fa-linkedin"></i></a></li>
                    </ul>
                </div>
                </div>
            </div>


            <!-- ================================================== MODAL ======================================================= -->


            <div class="modal fade text-center" id="theModal">
                <div class="modal-dialog">
                    <div class="modal-content"> </div>
                </div>
            </div>

            </div>
        </div>

    </div>

    <script type="text/javascript">

        // Ajax for zipcode feature
        function getInfo(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {

                    var x = this.responseText;
                    var loc = x.split("-");

                    document.getElementById("city").value = loc[0];
                    document.getElementById("state").value = loc[1];
                }
            };
            xmlhttp.open("GET","php_includes/getLocationInfo.php?q="+str,true);
            xmlhttp.send();
            }
        }

        // Reset foster form:
        function resetForm() {
            document.getElementById("fosterForm").reset();
        }

    </script>

    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>

    </body>
</html>
