<?php

    // Connect to DB:
    include('../php_includes/db_conx.php');

    // CRUD Class:
    include('crud.php');

    // New CRUD object with access to all CRUD methods and properties:
    $object = new Crud();

    // Get the user_id that was passed in:
    $user_id = $_GET['u'];

    // If insert button clicked:
    if(isset($_POST["action"])) {

        // LOAD: Only the data from the specific user_id
        if($_POST["action"] == "Load") {

          // Pagination - Set amount of records to display per page:
          $record_per_page = 6;
          $page = '';


          if(isset($_POST["page"])) {
              $page = $_POST["page"];
          }
          else {
              $page = 1;
          }

          $start_from = ($page - 1) * $record_per_page;

          // Crud object calling get_data_in_table with passed in SQL query:
          echo $object->get_data_in_table("SELECT * FROM pet_adopt WHERE uid='$user_id' ORDER BY id DESC LIMIT $start_from, $record_per_page");

          // Pagebreak + new div for pagination:
          echo '
              <br>
              <div align="center">';

          // Creating pagination links:
          echo $object->make_pagination_link("SELECT * FROM pet_adopt WHERE uid='$user_id' ORDER by id", $record_per_page);

            echo '</div><br />';
          echo '</div><br />';

       } // CLOSING ACTION => 'LOAD'

       // =============================================================================================================

      // INSERT: Insert data where id of SESSION['user'] = uid in pet_adopt table
      if($_POST["action"] == "Insert") {

          $name = mysqli_real_escape_string($object->connect, $_POST["name"]);
          $color = mysqli_real_escape_string($object->connect, $_POST["color"]);
          $gender = mysqli_real_escape_string($object->connect, $_POST["gender"]);
          $type = mysqli_real_escape_string($object->connect, $_POST["type"]);
          $age = mysqli_real_escape_string($object->connect, $_POST["age"]);
          $size = mysqli_real_escape_string($object->connect, $_POST["size"]);
          $zip = mysqli_real_escape_string($object->connect, $_POST["zip"]);
          $city = mysqli_real_escape_string($object->connect, $_POST["city"]);
          $state = mysqli_real_escape_string($object->connect, $_POST["state"]);
          $hair = mysqli_real_escape_string($object->connect, $_POST["hair"]);
          $description = mysqli_real_escape_string($object->connect, $_POST["description"]);
          $breed = mysqli_real_escape_string($object->connect, $_POST["breed"]);
          $avail = mysqli_real_escape_string($object->connect, $_POST["avail"]);
          $duration = mysqli_real_escape_string($object->connect, $_POST["duration"]);

          $image = $object->upload_file($_FILES["user_image"]);

          if (!file_exists("upload/$uid")) {
              mkdir("upload/$uid", 0777,true);
          }

          $destFile = "uploads/". $uid . "/";
          move_uploaded_file( $_FILES['image']['tmp_name'], $destFile );

          $query = " INSERT INTO pet_adopt (avail, duration, description, breed, hair, uid, name, color, gender, type, age, size,city,state,zip, image) VALUES ('".$avail."','".$duration."','".$description."','".$breed."','".$hair."','".$user_id."','".$name."', '".$color."', '".$gender."','".$type."','".$age."','".$size."','".$city."','".$state."','".$zip."','".$image."')";

          $object->execute_query($query);

          echo "Data Inserted";
       }

      // Updating Data:
      if($_POST["action"] == "Fetch Single Data") {

          $output = '';
          $query = "SELECT * FROM pet_adopt WHERE id = '".$_POST["user_id"]."'";
          $result = $object->execute_query($query);

          while($row = mysqli_fetch_array($result)) {
              $output["name"] = $row['name'];
              $output["description"] = $row['description'];
              $output["breed"] = $row['breed'];
              $output["hair"] = $row['hair'];
              $output["city"] = $row['city'];
              $output["state"] = $row['state'];
              $output["zip"] = $row['zip'];
              $output["type"] = $row['type'];
              $output["age"] = $row['age'];
              $output["size"] = $row['size'];
              $output["color"] = $row['color'];
              $output["gender"] = $row['gender'];
              $output["avail"] = $row['avail'];
              $output["duration"] = $row['duration'];
              $output["image"] = '<img src="upload/'.$row['image'].'" class="img-thumbnail" width="50" height="35" />';
              $output["user_image"] = $row['image'];
          }

          echo json_encode($output);
      }

     if($_POST["action"] == "Edit") {

       // If demo pet, dont update:
       if ($_POST["user_id"] < 13) {
         echo 'Cannot delete demo pets.';
       }

       else {
         $image = '';

         if($_FILES["user_image"]["name"] != '') {
           $image = $object->upload_file($_FILES["user_image"]);
         }

         else {
           $image = $_POST["hidden_user_image"];
         }

         $name = mysqli_real_escape_string($object->connect, $_POST["name"]);
         $type = mysqli_real_escape_string($object->connect, $_POST["type"]);
         $city = mysqli_real_escape_string($object->connect, $_POST["city"]);
         $state = mysqli_real_escape_string($object->connect, $_POST["state"]);
         $zip = mysqli_real_escape_string($object->connect, $_POST["zip"]);
         $age = mysqli_real_escape_string($object->connect, $_POST["age"]);
         $size = mysqli_real_escape_string($object->connect, $_POST["size"]);
         $color = mysqli_real_escape_string($object->connect, $_POST["color"]);
         $gender = mysqli_real_escape_string($object->connect, $_POST["gender"]);
         $avail = mysqli_real_escape_string($object->connect, $_POST["avail"]);
         $duration = mysqli_real_escape_string($object->connect, $_POST["duration"]);
         $description = mysqli_real_escape_string($object->connect, $_POST["description"]);
         $breed = mysqli_real_escape_string($object->connect, $_POST["breed"]);
         $hair = mysqli_real_escape_string($object->connect, $_POST["hair"]);

         $query = "UPDATE pet_adopt SET description = '".$description."',breed = '".$breed."',avail = '".$avail."',duration = '".$duration."',hair = '".$hair."',city = '".$city."',state = '".$state."',zip = '".$zip."', age = '".$age."',size = '".$size."',gender = '".$gender."', type = '".$type."',name = '".$name."', color = '".$color."', image = '".$image."' WHERE id = '".$_POST["user_id"]."'";
         $object->execute_query($query);

         echo 'Data Updated';
       }
     }

     if($_POST["action"] == "Delete") {

       // If demo pet, dont delete:
       if ($_POST["user_id"] < 13) {
         echo 'Cannot delete demo pets.';
       }

       else {
         $query = "DELETE FROM pet_adopt WHERE id = '".$_POST["user_id"]."'";
         $object->execute_query($query);
         echo "Data Deleted";
       }
     }

     if($_POST["action"] == "Search") {

      $search = mysqli_real_escape_string($object->connect, $_POST["query"]);
      $query = "
        SELECT * FROM pet_adopt
        WHERE description LIKE '%".$search."%'
        ORDER BY id DESC
      ";

      //echo $query;
      echo $object->get_data_in_table($query);
     }
    }
?>
