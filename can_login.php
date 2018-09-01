<?php  
 include 'database.php';  
 session_start();  
 $data = new Databases;  
 $message = '';  
 if(isset($_POST["login"]))  
 {  
      $field = array(  
           'username'     =>     $_POST["username"],  
           'password'     =>     $_POST["password"]  
      );  
     
      if($data->required_validation($field)) {
          
           if($data->can_login("users", $field)) {
               
                $_SESSION["username"] = $_POST["username"];  
                header("location:dashboard.php");  
           }  
           else {  
                $message = $data->error;  
           }  
      }  
      else {  
           $message = $data->error;  
      }  
 }  
 ?>  
 <!DOCTYPE html>  
 <html>  
      <head>  
           <title>Login</title>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
      </head>  
      <body>  
           <br />  
           <div class="container" style="width:500px;">  
                <h3 align="">Login</h3><br />  
                <?php  
                    if(isset($message)) {  
                         echo '<label class="text-danger">'.$message.'</label>';  
                    }  
                ?>  
                <form method="post">  
                     <label>Username</label>  
                     <input type="text" name="username" class="form-control" />  
                     <br />  
                     <label>Password</label>  
                     <input type="password" name="password" class="form-control" />  
                     <br />  
                     <input type="submit" name="login" class="btn btn-info" value="Login" />  
                </form>  
           </div>  
           <br />  
      </body>  
 </html>  