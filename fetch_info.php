<?php

  include('php_includes/db_conx.php');

  $id = $_GET['pet'];

  $sql = "SELECT pet_adopt.id, pet_adopt.name, pet_adopt.age, pet_adopt.gender, pet_adopt.breed, pet_adopt.color, pet_adopt.hair, pet_adopt.size, pet_adopt.city, pet_adopt.state, pet_adopt.duration, pet_adopt.avail, pet_adopt.duration, pet_adopt.description, pet_adopt.image, usersmeta.phone, usersmeta.company, usersmeta.email
          FROM pet_adopt
          INNER JOIN usersmeta WHERE pet_adopt.id='$id'";

  $query = mysqli_query($db_conx, $sql);

  $row = mysqli_fetch_array($query);
      $name = $row['name'];
      $image =$row['image'];
      $breed = $row['breed'];
      $hair = $row['hair'];
      $age = $row['age'];
      $description = $row['description'];
      $size = $row['size'];
      $gender = $row['gender'];
      $color = $row['color'];
      $city = $row['city'];
      $state = $row['state'];
      $avail = $row['avail'];
      $duration = $row['duration'];
      $email = $row['email'];
      $phone = $row['phone'];
      $company = $row['company'];
?>

<html>
<head>

  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <style>
      modal-body {
          overflow-y: auto;
          max-height: 500px;
      }

      .pet-name {
          text-align: center;
          font-weight: bold;
          font-size: 20px;
      }

      .modal-sub-header {
          font-weight: bold;
          text-decoration: underline;
          font-size: large;
      }

      .card-info {
        padding: 5px;
        font-size: small;
      }

  </style>
</head>
<body>
<div class="card-header">
  <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
  <h1><?php echo $name; ?> </h1>
</div>
<br>

<div class="card-img-wrapper">
  <div class="card-img">
    <img src="orgs/upload/<?php echo $image; ?>" height="225px" width="225px" style="border: 4px solid black;" />
  </div>
</div>
<br>
<br>

<!-- breed, description, avail, duration, city, state, zip, image -->
<div class="card-info">
  <p class='modal-sub-header'> Pet Information: </p>

  <div class="row">
    <div class="col-3"><span id="bold">Id: </span> <?php echo $id; ?> </div>
    <div class="col-3"><span id="bold">Age: </span> <?php echo $age; ?> </div>
    <div class="col-3"><span id="bold">Size: </span> <?php echo $size; ?> </div>
  </div>
  <hr>

  <div class="row">
    <div class="col-3"><span id="bold">Gender: </span> <?php echo $gender; ?> </div>
    <div class="col-3"><span id="bold">Hair: </span> <?php echo $hair; ?> </div>
    <div class="col-3"><span id="bold">Color: </span> <?php echo $color; ?> </div>
  </div>
  <hr>

  <div class="row">
    <div class="col-6"><span id="bold">Date Available: </span> <?php echo $avail; ?> </div>
    <div class="col-6"><span id="bold">Duration: </span> <?php echo $duration; ?> </div>
    </div>
  <hr>

  <div class="row">
    <div class="col-12"><span id="bold">Breed: </span> <?php echo $breed; ?> </div>
  </div>
  <hr>

  <div class="row">
    <div class="col-12"><span id="bold">Description: </span> <?php echo $description; ?> </div>
  </div>
  <br>

  <p class='modal-sub-header'> Contact Information: </p>

  <div class="row">
    <div class="col-6"><span id="bold">Organization: </span> <?php echo $company ?> </div>
    <div class="col-6"><span id="bold">Location: </span> <?php echo $city . ', ' . $state; ?> </div>
  </div>
  <hr>

  <div class="row">
    <div class="col-6"><span id="bold">Phone: </span> <?php echo $phone ?> </div>
    <div class="col-6"><span id="bold">Email: </span> <?php echo $email ?> </div>
  </div>

  <div class="card-footer"></div>
</div>

</body>
</html>
