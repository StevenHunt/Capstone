<?php

    // Create, Read, Update, and Delete functionality:
    include 'crud.php';

    // New crud object:
    $object = new Crud();

    // Checking login status:
    include_once("../php_includes/check_login_status.php");

    // Make sure username is set and sanatize it:
    $u = '';
    if(isset($_GET["u"])) {
        $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    }

    // If not, they aren't allowed here and send them back to homepage:
    else {
        header("location:../index.php");
        exit();
    }

    // Select the member from the users table -----------------------------------------
    $sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
    $user_query = mysqli_query($db_conx, $sql);
    $res = mysqli_fetch_array($user_query);
        $id = $res['id'];
        $e = $res['email'];
        $sud = $res['signup'];
        $userlevel = $res['userlevel'];

    // Select the user's meta (if available) ------------------------------------------
    $sql1 = "SELECT * FROM usersmeta WHERE uid='$id'";
    $sql_query = mysqli_query($db_conx, $sql1);

    $r = mysqli_fetch_array($sql_query);

    $data_check = mysqli_num_rows($r);

    if ($data_check < 1) {
      $sql = "INSERT INTO usersmeta (id, uid, username)
              VALUES('$id', '$id', '$u')";
      $query = mysqli_query($db_conx, $sql);
    }

    // Now make sure that user exists in the table ------------------------------------
    $numrows = mysqli_num_rows($user_query);

    // If they don't, exit:
    if($numrows < 1){
        echo "That user does not exist or is not yet activated, press back";
        exit();
    }

    // If you are a standard user, please leave! (No longer have multiple account types):
    if($userlevel == 'a')
        header('location:../users.php');

    // Check to see if the viewer is the account owner and let them in or direct them away:
    $isOwner = "no";
    if($u == $log_username && $user_ok == true){
        $isOwner = "yes";
    }
    if ($isOwner == "no") {
            header('location:../login.php');
    }
?>
<html>
    <head>

    <title>
        <?php if(preg_match('/s$/', $u)) {echo $u . "' "; } else { echo $u . "'s ";}?> Acct Info
    </title>

    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <link rel='stylesheet' href='style/edit_info.css'>
</head>
<body>

    <div class='container-fluid'>
        <div class='row layout' style='background-color: #26272b'>

            <!-- Nav Links -->
            <div class='col-md-3 be-nav'>

                <h2 class='nav-header'><?php  if(preg_match('/s$/', $u)) {echo $u . "' "; }else {echo $u . "'s ";}?> Dashboard<h2>

                <hr>

                <div class='nav-link-wrapper'>
                    <a class='dash-nav-link' href='dashboard.php?u=<?php echo $u; ?>'>Available Pets <a/>
                </div>

                <div class='nav-link-wrapper'>
                    <a class='dash-nav-link' id='active'>Account Information <a/>
                </div>

                <div class='nav-link-wrapper'>
                    <a class='dash-nav-link' href='../index.php'>Home <a/>
                </div>

                <div class='nav-link-wrapper'>
                    <a class='dash-nav-link' href='../logout.php'>Logout <a/>
                </div>

            </div>

            <!-- Main Table -->
            <div class='col-md-9 edit-info'>

                <div class='dash-header'>
                    <?php  if(preg_match('/s$/', $u)) {echo $u . "' "; }else {echo $u . "'s ";}?> Account Information
                </div>

                <div class='form-wrapper'>

                    <!-- ACCOUNT INFORMATION (READONLY) ===================================================================== -->
                    <form class="form-horizontal" class='ai-form'>

                        <div class='form-subheader'>
                            <p> Account Information </p>
                        </div>

                        <div class="form-group acc-info">
                            <label class="col-sm-2 control-label">User ID: </label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $id; ?></p>
                            </div>
                        </div>

                        <div class="form-group acc-info">
                            <label class="col-sm-2 control-label">Signup Date:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $sud; ?></p>
                            </div>
                        </div>

                        <div class="form-group acc-info">
                            <label class="col-sm-2 control-label">Username:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $u; ?></p>
                            </div>
                        </div>

                        <div class="form-group acc-info">
                            <label class="col-sm-2 control-label">Email:</label>
                            <div class="col-sm-10">
                                <p class="form-control-static"><?php echo $e; ?></p>
                            </div>
                        </div>
                    </form>

                    <!-- CHANGE PASSWORD ============================================================================ -->
                    <?php
                    $msg = '';

                    if(isset($_POST['change'])) {

                        if ($u == 'Test') {
                            $msg = "Demo account. Cannot change Test's password.";
                        }

                        else {
                            $oldpw = $_POST['oldpass'];
                            $curpw = $res['password'];

                            $hash_pass = md5($oldpw);

                            $newpass = $_POST['newpass'];
                            $confpass = $_POST['confpass'];

                            // If user puts in correct password:
                            if (md5($oldpw) == $curpw) {

                                // If user's new passwords match:
                                if ($newpass == $confpass) {

                                    $updatepw = hash(md5,$newpass);

                                    $sql = "UPDATE users SET password='$updatepw' WHERE username='$u'";

                                    if (mysqli_query($db_conx, $sql)) {
                                        $msg = "Password updated successfully! Please log back in.";
                                    } else {
                                        $msg = "Error updating record: " . mysqli_error($db_conx);
                                    }
                                }

                                else {
                                    $msg = "Passwords do not match...";
                                }
                            }

                            else {
                                $msg = "Wrong password.";
                            }
                        }
                    }
                    ?>
                    <form method="POST" class='gi-form'>
                        <div class='form-subheader'>
                            <p> Change Password </p>
                        </div>

                        <div class='row form-row'>
                            <div class='col-xs-3'>
                                <label for="oldpass">Old Password</label>
                                <input type="password" class="form-control" name="oldpass" placeholder="">
                            </div>
                        </div>

                        <div class='row form-row'>
                            <div class='col-xs-3'>
                                <label for="newpass">New Password</label>
                                <input type="password" class="form-control" name="newpass" placeholder="">
                            </div>

                            <div class='col-xs-3'>
                                <label for="confpass">Confirm Password</label>
                                <input type="password" class="form-control" name="confpass" placeholder="">
                            </div>
                        </div>

                        <button type="submit" name="change" class="btn btn-success update-btn"> Change </button>
                        <?php echo '<div style="color: red; margin-top: 2vh;">' . $msg . '</div>'; ?>
                    </form>

                    <!-- GENERAL INFORMATION ===================================================================================================================== -->

                    <?php

                    $mssg = '';

                    // If edit button pressed, update information in database:
                    if(isset($_POST['edit'])) {

                        $fname = filter_var($_POST['fname'], FILTER_SANITIZE_STRING);
                        $lname = filter_var($_POST['lname'], FILTER_SANITIZE_STRING);
                        $address1 = filter_var($_POST['address1'], FILTER_SANITIZE_STRING);
                        $address2 = filter_var($_POST['address2'], FILTER_SANITIZE_STRING);
                        $city = filter_var($_POST['city'], FILTER_SANITIZE_STRING);
                        $state = filter_var($_POST['state'], FILTER_SANITIZE_STRING);
                        $zip = filter_var($_POST['zipcode'], FILTER_SANITIZE_NUMBER_INT);
                        $phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);
                        $company = filter_var($_POST['company'], FILTER_SANITIZE_STRING);
                        $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);

                        if ($u == 'Test') {
                            $mssg = "Demo account. Cannot change Test's account information.";
                        }

                        else {

                            $sql = "UPDATE usersmeta SET fname='$fname', lname='$lname', address1='$address1', address2='$address2', city='$city', state='$state', zipcode='$zip', phone='$phone', company='$company', email='$email' WHERE uid=$id";

                            if (mysqli_query($db_conx, $sql)) {
                                $mssg = "Records sucessfully updated!";
                            } else {
                                $mssg = "Error updating record: " . mysqli_error($db_conx);
                            }
                        }
                    }

                    /* Static */
                      $id = $r['id'];
                      $username = $r['username'];
                    ?>


                    <form method="POST" class='gi-form'>
                        <div class='form-subheader'>
                            <p> Contact Informaiton </p>
                        </div>

                        <!-- Name Information -->
                        <div class='row form-row'>
                            <div class='col-xs-3'>
                                <label for="fname">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="" value="<?php if(!empty($r['fname'])){ echo $r['fname']; } elseif(isset($fname)){ echo $fname; } ?>">
                            </div>

                            <div class='col-xs-3'>
                                <label for="lname">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="" value="<?php if(!empty($r['lname'])){ echo $r['lname']; } elseif(isset($lname)){ echo $lname; } ?>">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class='row form-row'>
                            <div class='col-xs-4'>
                                <label for="address1">Address1</label>
                                <input type="text" class="form-control" id="address1" name="address1" placeholder="" value="<?php if(!empty($r['address1'])){ echo $r['address1']; } elseif(isset($address1)){ echo $address1; } ?>">
                            </div>

                            <div class='col-xs-4'>
                                <label for="address2">Address2</label>
                                <input type="text" class="form-control" id="address2" name="address2" placeholder="" value="<?php if(!empty($r['address2'])){ echo $r['address2']; } elseif(isset($address2)){ echo $address2; } ?>">
                            </div>
                        </div>

                        <!-- Address -->
                        <div class="row form-row">
                            <div class="col-xs-2">
                                <label for="zipcode"> Zipcode </label>
                                <input type="text" class="form-control" id="zipcode" name="zipcode" maxlength="5" onchange="getInfo(this.value)" value="<?php if(!empty($r['zipcode'])){ echo $r['zipcode']; } elseif(isset($zipcode)){ echo $zipcode; } ?>">
                            </div>

                            <div class="col-xs-3">
                                <label for='city'> City </label>
                                <input type="text" class="form-control" id="city" name="city" readonly value="<?php if(!empty($r['city'])){ echo $r['city']; } elseif(isset($city)){ echo $city; } ?>">
                            </div>

                            <div class="col-xs-2">
                                <label for='state'> State </label>
                                <input type="text" class="form-control" id="state" name="state" readonly value="<?php if(!empty($r['state'])){ echo $r['state']; } elseif(isset($state)){ echo $state; } ?>">
                            </div>
                        </div>

                        <!-- PHONE AND COMPANY INFORMATION -->
                        <div class="row form-row">
                            <div class="col-xs-2">
                                <label for="phone"> Phone Number </label>
                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="" value="<?php if(!empty($r['phone'])){ echo $r['phone']; } elseif(isset($phone)){ echo $phone; } ?>">
                            </div>

                            <div class="col-xs-3">
                                <label for='company'> Company </label>
                                <input type="text" class="form-control" id="company" name="company" placeholder="" value="<?php if(!empty($r['company'])){ echo $r['company']; } elseif(isset($company)){ echo $company; } ?>">
                            </div>

                            <div class="col-xs-3">
                                <label for='email'> Email </label>
                                <input type="text" class="form-control" id="email" name="email" placeholder="" value="<?php if(!empty($r['email'])){ echo $r['email']; } elseif(isset($email)){ echo $email; } ?>">
                            </div>
                        </div>

                        <button type="submit" id="edit" name="edit" class="btn btn-success update-btn"> Update </button>
                        <br>
                        <?php echo '<div style="color: red; margin-top: 2vh;">' . $mssg . '</div>'; ?>

                    </form>

                </div> <!-- Close form-wrapper -->
            </div>
        </div>
    </div> <!-- End .container-fluid -->

<script>

    // Phone number formatting:
    $("input[type='tel']").each(function(){
        $(this).on("change keyup paste", function (e) {
            var output,
            $this = $(this),
            input = $this.val();

            if(e.keyCode != 8) {
                input = input.replace(/[^0-9]/g, '');
                var area = input.substr(0, 3);
                var pre = input.substr(3, 3);
                var tel = input.substr(6, 4);

                if (area.length < 3) {
                    output = "(" + area;
                }

                else if (area.length == 3 && pre.length < 3) {
                    output = "(" + area + ")" + " " + pre;
                }

                else if (area.length == 3 && pre.length == 3) {
                    output = "(" + area + ")" + " " + pre + "-" + tel;
                }

                $this.val(output);
            }
        });
    });

    // AJAX FOR ZIPCODE FEATURE ==========================================================
    function getInfo(str) {
        if (str == "") {
            document.getElementById("txtHint").innerHTML = "";
            return;
        }

        else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            }

            else {
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

            xmlhttp.open("GET","../php_includes/getLocationInfo.php?q="+str,true);

            xmlhttp.send();
        }
    }
</script>


    </body>
</html>
