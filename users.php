<?php

    include_once("php_includes/check_login_status.php");

    $u = "";
    $userlevel = "";
    $joindate = "";
    $lastsession = "";

    if(isset($_GET["u"])){
        $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    } else {
        header("location:index.php");
        exit();
    }

    $sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
    $user_query = mysqli_query($db_conx, $sql);

    $numrows = mysqli_num_rows($user_query);
    if($numrows < 1){
        echo '
        <html>
        <head>
          <title> Repaw | Failed </title>
          <link rel="stylesheet" href="style/login-fail.css">
          <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
        </head>
        <body>
        <div class="all-wrap">
          <div class="all">
            <div class="yarn"></div>
            <div class="cat-wrap">
              <div class="cat">
                <div class="cat-upper">
                  <div class="cat-leg"></div>
                  <div class="cat-leg"></div>
                  <div class="cat-head">
                    <div class="cat-ears">
                      <div class="cat-ear"></div>
                      <div class="cat-ear"></div>
                    </div>
                    <div class="cat-face">
                      <div class="cat-eyes"></div>
                      <div class="cat-mouth"></div>
                      <div class="cat-whiskers"></div>
                    </div>
                  </div>
                </div>
                <div class="cat-lower-wrap">
                  <div class="cat-lower">
                    <div class="cat-leg">
                      <div class="cat-leg">
                        <div class="cat-leg">
                          <div class="cat-leg">
                            <div class="cat-leg">
                              <div class="cat-leg">
                                <div class="cat-leg">
                                  <div class="cat-leg">
                                    <div class="cat-leg">
                                      <div class="cat-leg">
                                        <div class="cat-leg">
                                          <div class="cat-leg">
                                            <div class="cat-leg">
                                              <div class="cat-leg">
                                                <div class="cat-leg">
                                                  <div class="cat-leg">
                                                    <div class="cat-paw"></div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="cat-leg">
                      <div class="cat-leg">
                        <div class="cat-leg">
                          <div class="cat-leg">
                            <div class="cat-leg">
                              <div class="cat-leg">
                                <div class="cat-leg">
                                  <div class="cat-leg">
                                    <div class="cat-leg">
                                      <div class="cat-leg">
                                        <div class="cat-leg">
                                          <div class="cat-leg">
                                            <div class="cat-leg">
                                              <div class="cat-leg">
                                                <div class="cat-leg">
                                                  <div class="cat-leg">
                                                    <div class="cat-paw"></div>
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="cat-tail">
                      <div class="cat-tail">
                        <div class="cat-tail">
                          <div class="cat-tail">
                            <div class="cat-tail">
                              <div class="cat-tail">
                                <div class="cat-tail">
                                  <div class="cat-tail">
                                    <div class="cat-tail">
                                      <div class="cat-tail">
                                        <div class="cat-tail">
                                          <div class="cat-tail">
                                            <div class="cat-tail">
                                              <div class="cat-tail">
                                                <div class="cat-tail">
                                                  <div class="cat-tail -end"></div>
                                                </div>
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>


          <div class="center">
            <div class="text-center">
              That user does not exist or is not yet activated! <br>
              Please return back to <a href="index.php"> Repaw </a> 
            </div>
          </div>
        </body>
        </html>
        ';
        exit();
    }

    $isOwner = "no";

    if($u == $log_username && $user_ok == true){
        $isOwner = "yes";
    }

    if ($isOwner == "no") {
            header('location:login.php');
    }

    while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {

        $profile_id = $row["id"];
        $userlevel = $row["userlevel"];
        $signup = $row["signup"];
        $lastlogin = $row["lastlogin"];
        $joindate = strftime("%b %d, %Y", strtotime($signup));
        $lastsession = strftime("%b %d, %Y", strtotime($lastlogin));
    }

    if ($userlevel == 'b') {
        header("location: orgs/dashboard.php?u=".$_SESSION["username"]);
    }

?>
<!DOCTYPE html>
<html>
<head>

    <meta charset="UTF-8">

    <title><?php echo $u . "'s Dashboard"; ?></title>

    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <link rel="stylesheet" href="style/template_style.css">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    <script src="js/main.js"></script>
    <script src="js/ajax.js"></script>

</head>
<body style="background-color:#f3f3f3">

    <?php include_once("inc/template_pageTop.php"); ?>

    <div id="pageMiddle" style="font-weight:bold;">

        <h3><?php echo $u; ?></h3>
        <p>Is the viewer the page owner, logged in and verified? <b><?php echo $isOwner; ?></b></p>
        <p>User Level: <?php echo $userlevel; ?></p>
        <p>Join Date: <?php echo $joindate; ?></p>
        <p>Last Session: <?php echo $lastsession; ?></p>


        <br>
        <br>
        <br>
        <br>

        <div style="background-color:black;height:10vh; text-align:center; border:5px solid red;: ">
            <br>
            <p style="color:yellow;font-weight:bold"> PAGE UNDER CONSTRUCTION - NORMA SANCHEZ</p><br>
            <div style="color:yellow"><span class="glyphicon glyphicon-alert"></span></div>
        </div>
    </div>

</body>
</html>
