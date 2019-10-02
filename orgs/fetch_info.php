<?php

    include('../php_includes/db_conx.php');

    $id = $_GET['pet'];

    $sql = "SELECT * FROM pet_adopt WHERE id='$id'";

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
    $zip = $row['zip'];
    $avail = $row['avail'];
    $duration = $row['duration'];
?>
<html>


<head>
<style>

    modal-body {
        position: relative;
        overflow-y: auto;
        max-height: 5s00px;
        padding: 15px;
    }

    table {
        border-collapse: collapse;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

</style>
</head>
<body>

    <div class="modal-header">
        <button type="button" onclick="javascript:window.location.reload()" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h1 style='text-align:center; color: black;'> <?php echo $name; ?> </h1>
    </div>

    <div class="modal-body">
        <div class="row">
            <!-- ROW 1: Image -->
            <div class="col-xs-6">
                <img src="upload/<?php echo $image;?>" class="img-thumbnail center" width="250" height="300" />
            </div>

            <!-- ROW 2: Information -->
            <div class="col-xs-6">
                <table width="220" style="margin-left:10px">
                    <tr>
                        <td colspan="3"><small><b>Repaw Id:</b> <?php echo $id; ?></small>  </td>
                    </tr>
                    <tr>
                        <td colspan="3"><small><b>Breed:</b> <?php echo $breed; ?></small>  </td>
                    </tr>
                    <tr>
                        <td colspan="3"><small><b>Age:</b> <?php echo $age; ?></small>  </td>
                    </tr>
                    <tr>
                        <td colspan="3"><small><b>Size:</b> <?php echo $size; ?></small>  </td>
                    </tr >
                    <tr>
                        <td colspan="3"><small><b>Gender:</b> <?php echo $gender; ?></small>  </td>
                    </tr>
                    <tr>
                        <td colspan="3"><small><b>Color:</b> <?php echo $color; ?></small>  </td>
                    </tr>
                    <tr>
                        <td colspan="3"><small><b>Description:</b> <?php echo $description; ?></small>  </td>
                    </tr>
                    <tr>
                        <td colspan="3"><small><b>Availability:</b> <?php echo $avail; ?></small>  </td>
                    </tr>
                    <tr>
                        <td colspan="3"><small><b>Duration:</b> <?php echo $duration; ?></small>  </td>
                    </tr>

                </table>

            </div>
        </div>
    </div> <!-- Close Modal body -->
