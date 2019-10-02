<?php
    // require 'mailer.php';
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    session_start();

    // If user is logged in, take them to their dashboard:
    if(isset($_SESSION["username"])){
        header("location: users.php?u=".$_SESSION["username"]);
        exit();
    }
?>

<?php

    // Check username (via Ajax):
    if(isset($_POST["usernamecheck"])){

        // Connect to db:
        include_once("php_includes/db_conx.php");

        // Get username and sanatize it:
        $username = preg_replace('#[^a-z0-9]#i', '', $_POST['usernamecheck']);

        // Check if username is taken:
        $sql = "SELECT id FROM users WHERE username='$username' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $uname_check = mysqli_num_rows($query);

        // Check username length:
        if (strlen($username) < 3 || strlen($username) > 16) {
            echo '<p style="color:red; font-weight: bold">3-16 Characters</p>';
            exit();
        }

        // Check if username starts with letter:
        if (is_numeric($username[0])) {
            echo '<p style="color:red;">Usernames must begin with a letter</p>';
            exit();
        }

        // If username isn't taken:
        if ($uname_check < 1) {
            echo '<p style="color:#008c23; font-weight: bold"><span class="glyphicon glyphicon-ok"></span> ' . $username . ' is OK</p>';
            exit();
        }

        else {
            echo '<p style="color:red; font-weight: bold"><span class="glyphicon glyphicon-remove"></span> ' . $username . ' is taken.</p>';
            exit();
        }
    }

    // Check email (via Ajax):
    if(isset($_POST["emailcheck"])){

        // Connect to db:
        include_once("php_includes/db_conx.php");

        // Get username and sanatize it:
        $email = $_POST['emailcheck'];

        // Check if email is already associated to an account:
        $sql = "SELECT id FROM users WHERE email='$email' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $email_check = mysqli_num_rows($query);

        if (strpos($email, '@') == false) {
            echo '<p style="color:red; font-weight: bold"><span class="glyphicon glyphicon-remove"></span> ' . $email . ' is not formatted properly. </p>';
            exit();
        }

        else {

          // If username isn't taken:
          if ($email_check < 1) {
              echo '<p style="color:#008c23; font-weight: bold"><span class="glyphicon glyphicon-ok"></span> ' . $email . ' is OK</p>';
              exit();
          }

          else {
              echo '<p style="color:red; font-weight: bold"><span class="glyphicon glyphicon-remove"></span> ' . $email . ' is already in use. </p>';
              exit();
          }
        }
    }
?>

<?php

    // Registration code (via Ajax):
    if(isset($_POST["u"])){

        // Connect to DB:
        include_once("php_includes/db_conx.php");

        // Creating local variables via posted data:
        $u = preg_replace('#[^a-z0-9]#i', '', $_POST['u']);
        $e = mysqli_real_escape_string($db_conx, $_POST['e']);
        $p = $_POST['p'];
        $g = $_POST['g'];

        // Get user's IP address:
        $ip = preg_replace('#[^0-9.]#', '', getenv('REMOTE_ADDR'));

        // Duplicate data checks for email and username:
        $sql = "SELECT id FROM users WHERE username='$u' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $u_check = mysqli_num_rows($query);

        // ------------------------------------------------------
        $sql = "SELECT id FROM users WHERE email='$e' LIMIT 1";
        $query = mysqli_query($db_conx, $sql);
        $e_check = mysqli_num_rows($query);

        // If user ignores asyncronous data error handling, the form will not submit:

        // All form fields must be filled in:
        if($u == "" || $e == "" || $p == ""){
            exit();
        }

        // Username is taken:
        else if ($u_check > 0){
          echo "
          <script>
              var status = _('status');
              status.innerHTML = 'Fill out all of the form data';
          </script>";
          exit();
        }

        // Email not formtted properly:
        else if (strpos($e, '@') == false) {
          echo "
          <script>
              var status = _('status');
              status.innerHTML = 'Email not formatted properly.;
          </script>";
          exit();
        }

        // Email is taken:
        else if ($e_check > 0){
            exit();
        }

        // Username length is incorrect:
        else if (strlen($u) < 3 || strlen($u) > 16) {
            exit();
        }

        // Username cannot begin with a number:
        else if (is_numeric($u[0])) {
            exit();
        }

        // IF EVERYTHING CHECKS OUT => INSERT DATA INTO DATABASE:
        else {

          // Hash password:
          $p_hash = md5($p);

          // Add user info into the database table for the main site table
          $sql = "INSERT INTO users (username, email, password, userlevel, ip, signup, lastlogin, notescheck)
                  VALUES('$u','$e','$p_hash','b','$ip',now(),now(),now())";
          $query = mysqli_query($db_conx, $sql);
          $uid = mysqli_insert_id($db_conx);

          /* PHP MAILER ===================================================================================== */
          // $mail = new PHPMailer(true);

          try {

              date_default_timezone_set('Etc/UTC');

             // Load Composer's autoloader
              require 'vendor/autoload.php';

              ///Create a new PHPMailer instance
              $mail = new PHPMailer;

              //Tell PHPMailer to use SMTP
              $mail->isSMTP();

              //Ask for HTML-friendly debug output
              $mail->Debugoutput = 'html';

              //Set the hostname of the mail server
              $mail->Host = 'smtp.gmail.com';

              //Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
              $mail->Port = 587;

              //Set the encryption system to use - ssl (deprecated) or tls
              $mail->SMTPSecure = 'tls';

              //Whether to use SMTP authentication
              $mail->SMTPAuth = true;

              //Username to use for SMTP authentication - use full email address for gmail
              $mail->Username = "xxxxxxxxxxxxxxxxxxxxxx@xxxxxxxxxxxx.com";

              //Password to use for SMTP authentication
              $mail->Password = "xxxxxxxxxxxxxx";

              //Set who the message is to be sent from
              $mail->setFrom('Auto_Response@Repaw.io', 'Repaw Admin');

              //Who message is to be sent to:
              $mail->addAddress($e, $username);

              /* Content */
              $mail->isHTML(true);
              $mail->Subject = 'Repawistory Account Activation';
              $mail->Body    = '<!DOCTYPE html><html><head><meta charset="UTF-8"><title>Repawsitory Message</title></head><body style="margin:0px; font-family:Tahoma, Geneva, sans-serif;"><div style="padding:10px; background:#333; font-size:24px; color:#CCC;"></a>Repawsitory Account Activation</div><div style="padding:24px; font-size:17px;">Hello '.$u.',<br /><br />Click the link below to activate your account when ready:<br /><br /><a href="https://www.stevenhunt.dev/d/repaw/activation.php?id='.$uid.'&u='.$u.'&e='.$e.'&p='.$p_hash.'">Click here to activate your account now</a><br /><br />Login after successful activation using your:<br />* E-mail Address: <b>'.$e.'</b></div></body></html>';
              $mail->AltBody = 'Alt.';

              $mail->send();
              echo '<p> A message has been sent to <span style="color: #008c23; font-weight: bold">' . $e . '</span> <br> Please check your email shortly... </p>';
          }

            catch (Exception $e) {
                echo '<p style="color: red; font-weight: bold"><span class="glyphicon glyphicon-remove"></span> Message could not be sent. Mailer Error: </p> ', $mail->ErrorInfo;
            }
            exit();
        }
        exit();
        header("location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en" >
<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Repaw | Register</title>

	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <!-- Bootstrap Icons -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>


	<link rel="stylesheet" href="style/signup.css">
  <link rel="stylesheet" href="style/signup-dog.css">

  <!-- Font-Awesome Icon -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

  <script src="js/main.js"></script>
	<script src="js/ajax.js"></script>

  <script>

      // Restrict specific characters in email and username submission (called on keyup during form handling) ============================
      function restrict(elem){

          // The passed in username or email:
          var tf = _(elem);

          // Construct a new regular expression:
          var rx = new RegExp;

          // Email cannot contain spaces:
          if(elem == "email"){
              rx = /[' "]/gi;
          }

          // Username must contain only numbers and letters (RegEx: Find any character not between the brackets)
          else if(elem == "username"){
              rx = /[^a-z0-9]/gi;
          }

          // Remove blanks asyncronously:
          tf.value = tf.value.replace(rx, "");
      }

      // Check for empty text fields on form submission (onfocus) =======================================================================
      function emptyElement(x){
          _(x).innerHTML = "";
      }

      // Ajax checks username ===========================================================================================================
      function checkusername(){

        // Get value of passed in username:
        var u = _("username").value;

        // If username isn't blank:
        if(u != ""){

          _("unamestatus").innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:16px"></i> Checking ...';
          var ajax = ajaxObj("POST", "signup.php");

          // When readyState property changes:
          ajax.onreadystatechange = function() {

            // If response from database:
            if(ajaxReturn(ajax) == true) {

              // Display it:
              _("unamestatus").innerHTML = ajax.responseText;
            }
          }

          // Send request to server (POST => sending user input):
          ajax.send("usernamecheck="+u);
        }
      }

      // Ajax checks email: =============================================================================================================
      function checkemail(){

        var e = _("email").value;

        // If email field isn't empty... check:
        if(e != ""){

          _("emailstatus").innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:16px"></i> Checking ...';
          var ajax = ajaxObj("POST", "signup.php");

          // When readyState property changes:
          ajax.onreadystatechange = function() {

            //
            if(ajaxReturn(ajax) == true) {
              _("emailstatus").innerHTML = ajax.responseText;
            }
          }

          // Send request to server (POST => sending user input):
          ajax.send("emailcheck="+e);
        }
      }


      function signup(){
          var u = _("username").value;
          var e = _("email").value;
          var p1 = _("pass1").value;
          var p2 = _("pass2").value;

          var status = _("status");
          if(u == "" || e == "" || p1 == "" || p2 == ""){
              status.innerHTML = "<p style='color: red; font-weight: bold;'><span class='glyphicon glyphicon-remove'></span> Fill out all of the form data";
          } else if(p1 != p2){
              status.innerHTML = "<p style='color: red; font-weight: bold;'><span class='glyphicon glyphicon-remove'></span> Your password fields do not match";
          } else {
              status.innerHTML = '<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>  Please wait ...';
              var ajax = ajaxObj("POST", "signup.php");
              ajax.onreadystatechange = function() {
                  if(ajaxReturn(ajax) == true) {
                      if(ajax.responseText != "signup_success"){
                          status.innerHTML = ajax.responseText;
                      } else {
                          window.scrollTo(0,0);
                          _("signupform").innerHTML = "<p style='color:#008c23;'><span class='glyphicon glyphicon-ok'></span> OK "+u+", check your email inbox at <u>"+e+"</u> in a moment to activate your account.";
                      }
                  }
              }
              ajax.send("u="+u+"&e="+e+"&p="+p1);
          }
      }

  </script>

</head>
<body>

  <div class="form-wrapper">

    <!-- ================================ SVG DOG =========================================== -->

    <form name="signupform" id="signupform" onsubmit="return false;">

      <div class='dog-wrapper'>
        <div class="dog">

          <div class="dog-body">
            <div class="dog-spot">
            <div class="dog-tail">
              <div class="dog-tail">
                <div class="dog-tail">
                  <div class="dog-tail">
                    <div class="dog-tail">
                      <div class="dog-tail">
                        <div class="dog-tail">
                          <div class="dog-tail"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          </div>

          <div class="dog-torso"></div>
          <div class="dog-head">
            <div class="dog-ears">
              <div class="dog-ear"></div>
              <div class="dog-ear"></div>
            </div>

            <div class="dog-eyes">
              <div class="dog-eye"></div>
              <div class="dog-eye"></div>
            </div>

            <div class="dog-muzzle">
              <div class="dog-tongue"></div>
            </div>

          </div> <!-- Close dog-head -->
        </div> <!-- Close dog -->
      </div> <!-- Close dog-wrapper -->

      <br>

      <div class='form-header'>
        <span> Repaw Registration </span>
      </div>

      <div class="inputGroup">
        <input class="form-control form-control-sm" id="username" placeholder="Username" type="text" onblur="checkusername()" onkeyup="restrict('username')" maxlength="16">
        <span class="notify" id="unamestatus"> </span>
    	</div>

      <div class="inputGroup">
        <input class="form-control form-control-sm" id="email" placeholder="Email" type="text" onblur="checkemail()" onfocus="emptyElement('status')" onkeyup="restrict('email')" maxlength="88">
        <span class='notify' id="emailstatus"> </span>
  	  </div>

      <div class="inputGroup">
        <input class="form-control form-control-sm" id="pass1" placeholder="Password" type="password" onfocus="emptyElement('status')" maxlength="16">
      </div>

      <div class="inputGroup">
        <input class="form-control form-control-sm" id="pass2" type="password" placeholder="Confirm" onfocus="emptyElement('status')" maxlength="16">
      </div>

      <div class="inputGroup">
  		  <button class="btn btn-signup" id="signupbtn" onclick="signup()">Create Account</button>
  	  </div>

      <div style='text-align: center'>
        <p id="status"></p>
      </div>

  	  <br>

      <p class='form-links' style="text-align:center">
          <a href="forgot_pass.php">Forgot Password?</a> &nbsp;
          | &nbsp; <a href="login.php"> Login!</a>
      </p>
    </form>
  </div> <!-- Close form-wrapper -->

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <script src='http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js'></script>
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
  <script src='https://unpkg.com/@reactivex/rxjs/dist/global/Rx.min.js'></script>
  <script src='https://unpkg.com/rxcss@latest/dist/rxcss.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/hammer.js/2.0.8/hammer.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js'></script>




</body>

</html>
