<?php
    include("php_includes/check_login_status.php");
    include('php_includes/simple_html_dom.php');

    if($user_ok == true){
        $username = $_SESSION['username'];
    }
?>

<?php

/* Logging in */
if(isset($_POST["e"])){

	include_once("php_includes/db_conx.php");

	$e = mysqli_real_escape_string($db_conx, $_POST['e']);
	$p = md5($_POST['p']);

    $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

	if($e == "" || $p == ""){
		header('location:login.php');
	}

    else {
		$sql = "SELECT id, username, password FROM users WHERE email='$e' AND activated='1' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $row = mysqli_fetch_row($query);

        $db_id = $row[0];
		    $db_username = $row[1];
        $db_pass_str = $row[2];

        if($p != $db_pass_str){
			header('location:login.php');
		}

        else {
			// CREATE THEIR SESSIONS AND COOKIES
			$_SESSION['userid'] = $db_id;
			$_SESSION['username'] = $db_username;
			$_SESSION['password'] = $db_pass_str;
			setcookie("id", $db_id, strtotime( '+30 days' ), "/", "", "", TRUE);
			setcookie("user", $db_username, strtotime( '+30 days' ), "/", "", "", TRUE);
    		setcookie("pass", $db_pass_str, strtotime( '+30 days' ), "/", "", "", TRUE);

            // UPDATE THEIR "IP" AND "LASTLOGIN" FIELDS
			$sql = "UPDATE users SET ip='$ip', lastlogin=now() WHERE username='$db_username' LIMIT 1";
            $query = mysqli_query($db_conx, $sql);
			echo $db_username;

            header('location:users.php?u=' . $db_username);
		}
	}
	exit();
}


?>

<html>

<head>

    <title> Repaw | Rescue </title>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

    <link rel='stylesheet' href="style/rescue_results.css">

    <script>

        $(document).ready(function() {
          $('#modal').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            alert(id);
          });
        });

    </script>

</head>

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
                    <a class="nav-link" href="foster.php">Foster Care</a>
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
    <div class="body-container rounded">
    <?php

    if(isset($_POST['search'])) {

        $type=$_POST['type'];
        $user_zip=$_POST['zipcode'];
        $dfz=$_POST['distance_from_zip'];
        $size=$_POST['size'];
        $age=$_POST['age'];
        $gender=$_POST['gender'];

        $pet = '';


        // ZIPCODES GENERATOR ===========================

        $url = 'https://www.zip-codes.com/zip-code-radius-finder.asp?zipmileslow='.$dfz.'&zipmileshigh='.$dfz.'&zip1='.$user_zip.'&submit=Search';

        // Create DOM (document object model) from url
        $html = file_get_html($url);

        // Array to hold parsed data
        $links = array();

        // Parse HTML and put all elements 'a' into array $links
        foreach($html->find('a') as $a) {
            $links[] = $a->href;
        }

        // Remove all elements that do not contain the searchword => zip-code-
        $searchword = "zip-code-";
        $zipstrings = array();
        foreach($links as $k=>$v) {
            if(preg_match("/\b$searchword\b/i", $v)) {
                $zipstrings[$k] = $v;
            }
        }

        // Slicing unwanted elements from array (First 21 and the last 13 are random hyperlinks that contain the keyword, but that we don't want):
        $zipstrings = array_slice($zipstrings,21);
        $zipstrings = array_slice($zipstrings,0,-13);

        // Chop the 5 digit zip from each array element:
        foreach ($zipstrings as &$str) {
            $str = substr(str_replace('.asp', '', $str), -5);
        }

        // Convert zip strings to ints
        $zips = array_map('intval', $zipstrings);

        /* =================== SQL ==================== */

        $sql1 = '';

        $sql1 = "SELECT * FROM pet_adopt
                 WHERE zip
                 IN(".implode(',',$zips).") AND type='$type' ";

        if ($gender != 'Either') {
          $sql1 .= " AND gender='$gender' ";
        }

        if ($age != 'Either') {
          $sql1 .= " AND age='$age' ";
        }

        if ($size != 'Either') {
          $sql1  .= " AND size='$size' ";
        }

        $query = mysqli_query($db_conx, $sql1);

        $numrows = mysqli_num_rows($query);

        if($type == '1') {
            if($numrows != '1') {
                echo "<h2 style='text-align:center;'> (" . $numrows . ") dogs found within " . $dfz . " miles of " . $user_zip . "</h2>";
            }
            else {
                echo "<h2 style='text-align:center;'> (1) dog found within " . $dfz . " miles of " . $user_zip . "</h2>";
            }
        }
        else {
            if($numrows != '1') {
                echo "<h2 style='text-align:center;'> (" . $numrows . ") cats found within " . $dfz . " miles of " . $user_zip . "</h2>";
            }
            else {
                echo "<h2 style='text-align:center;'> (1) cat found within " . $dfz . " miles of " . $user_zip . "</h2>";
            }
        }

        echo '<br><br>

        <div class="container">
        <div class="row">';
    }

    if(!$numrows == 0) {

            $pet_array = array();

            while($row = mysqli_fetch_array($query)) {

            $pet_array = $row;

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
        }

        else {

            $msg = "Sorry no results found";
        }
        ?>

            </div> <!-- Close row -->
        </div> <!-- Close card-columns -->
    </div> <!-- Close body-container -->


    <!-- MODAL (CONTENT PULLED FROM FETCH_RECORD.PHP) -->
    <div class="modal fade text-center" id="theModal">
        <div class="modal-dialog">
            <div class="modal-content"> </div>
        </div>
    </div>


    <!-- JavaScript -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.css'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullPage.js/2.9.6/jquery.fullpage.min.js'></script>

    </body>
</html>
