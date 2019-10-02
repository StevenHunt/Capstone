<?php

    // Create, Read, Update, and Delete functionality:
    include 'crud.php';

    // New crud object:
    $object = new Crud();

    // Checking login status:
    include_once("../php_includes/check_login_status.php");

    // Make sure username is set and sanatize it:
    if(isset($_GET["u"])) {
        $u = preg_replace('#[^a-z0-9]#i', '', $_GET['u']);
    }

    // If not, they aren't allowed here and send them back to homepage:
    else {
        header("location:../index.php");
        exit();
    }

    // Get general user info:
    $sql = "SELECT * FROM users WHERE username='$u' AND activated='1' LIMIT 1";
    $user_query = mysqli_query($db_conx, $sql);

    $users = mysqli_fetch_array($user_query);
        $id = $users['id'];
        $e = $users['email'];
        $userlevel = $users['userlevel'];


    // Get user-meta:
    $sql = "SELECT * FROM usersmeta WHERE uid='$id'";
    $sql_query2 = mysqli_query($db_conx, $sql);

    $userMeta = mysqli_fetch_array($sql_query2);
        $um_fname = $userMeta['fname'];
        $um_lname = $userMeta['lname'];
        $um_address1 = $userMeta['address1'];
        $um_address2 = $userMeta['address2'];
        $um_city = $userMeta['city'];
        $um_state = $userMeta['state'];
        $um_zip = $userMeta['zipcode'];
        $um_phone = $userMeta['phone'];
        $um_company = $userMeta['company'];
        $um_email = $userMeta['email'];

    // Now make sure that user exists in the table
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

    // Get all pets that match user's id and order them by ID:
    $query = "SELECT * FROM pet_adopt WHERE uid='$id' ORDER BY id DESC";
    $result = mysqli_query($db_conx, $query);
?>

<html>
    <head>
    <title><?php if(preg_match('/s$/', $u)) {echo $u . "' "; } else { echo $u . "'s ";}?> Dashboard</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

    <script>

        /* MODAL */
        $('#modal').on('show.bs.modal', function(e) {
            var id = $(e.relatedTarget).data('id');
            alert(id);
        });

    </script>

    <link rel='stylesheet' href='style/dashboard.css'>
</head>
<body>

<div class='container-fluid'>
    <div class='row layout'>

        <!-- Nav Links -->
        <div class='col-md-3 be-nav'>

            <h2 class='nav-header'><?php  if(preg_match('/s$/', $u)) {echo $u . "' "; }else {echo $u . "'s ";}?> Dashboard<h2>

            <hr>

            <div class='nav-link-wrapper'>
                <a class='dash-nav-link' id='active'>Available Pets <a/>
            </div>

            <?php

                if ($um_zip == '' || $um_company == '' || $um_email == '' || $um_phone == '') {
                    echo '<button type="button" class="btn btn-primary add-pet-btn btn-block" onclick="window.alert(\'Please fill in all account information. \')"> Add Record</button>';
                }

                else {
                    echo '<button type="button" name="add" id="add" class="btn btn-primary add-pet-btn btn-block" data-toggle="collapse" data-target="#user_collapse"> Add Record</button>';
                }
            ?>


            <div id="user_collapse" class="collapse">

                <!--=== FORM START ===-->
                <form method="post" id="user_form" class='add-pet-form'>
                    <div class="radio radio-info radio-inline">
                        <input type="radio" id="Dog" value="1" onclick="setSelect('dogdd')"  name="type" checked="">
                        <label for="Dog"> Dog </label>
                    </div>
                    <br>
                    <br>
                    <div class="radio radio-danger radio-inline">
                        <input type="radio" id="Cat" value="2" onclick="setSelect('catdd')" name="type">
                        <label for="Cat"> Cat</label>
                    </div>

                    <br>
                    <br>

                    <!-- NAME -->
                    <div class="form-row form-input">
                        <div class="col">
                            <label for='name'> General Information </label>
                            <input type="text" name="name" id="name" placeholder="Name" class="form-control" required/>
                        </div>
                    </div>

                    <!-- AGE -->
                    <div class="form-row form-input">
                        <div class="col">
                            <select name="age" id="age" class="form-control" required>
                                <option value="">Age</option>
                                <option value="Young">Young</option>
                                <option value="Teen">Teen</option>
                                <option value="Adult">Adult</option>
                                <option value="Senior">Senior</option>
                            </select>
                        </div>
                    </div>

                    <!-- GENDER -->
                    <div class='form-row form-input'>
                        <div class="col">
                            <select name="gender" id="gender" class="form-control" required>
                                <option value="">Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                            </select>
                        </div>
                    </div>

                    <!-- BREED -->
                    <div class='form-row form-input'>
                        <?php
                        /* DOG QUERY */

                        $sql = "SELECT breed FROM dog_breeds";

                        $query = mysqli_query($db_conx, $sql);

                        $column = array();

                        while($row = mysqli_fetch_array($query)) {
                            $column[] = $row['breed'];
                        }

                        /* CAT QUERY */

                        $sql1 = "SELECT breed FROM cat_breeds";

                        $query1 = mysqli_query($db_conx, $sql1);

                        $column1 = array();

                        while($row1 = mysqli_fetch_array($query1)) {
                            $column2[] = $row1['breed'];

                            $cname = $row1['breed'];
                        }
                        ?>
                        <select class="custom-select my-1 mr-sm-2 form-control form-input" name="breed" id="breed"> </select>
                    </div>


                    <!-- COLOR -->
                    <div class="form-row form-input">
                        <select name="color" id="color" class="form-control" required>
                            <option value="">Color</option>
                            <option value="White">White</option>
                            <option value="Black">Black</option>
                            <option value="Gray">Gray</option>
                            <option value="Brown">Brown</option>
                            <option value="Yellow">Yellow / Orange</option>
                        </select>
                    </div>

                    <!-- HAIR -->
                    <div class="form-row form-input">
                        <select name="hair" id="hair" class="form-control" required>
                            <option value="">Hair</option>
                            <option value="Short">Short</option>
                            <option value="Medium">Medium</option>
                            <option value="Long">Long</option>
                        </select>
                    </div>

                    <!-- SIZE -->
                    <div class="form-row form-input">
                        <select name="size" id="size" class="form-control" required>
                            <option value="">Size</option>
                            <option value="XSmall">Extra Small</option>
                            <option value="Small">Small</option>
                            <option value="Medium">Medium</option>
                            <option value="Large">Large</option>
                            <option value="XLarge">Extra Large</option>
                        </select>
                    </div>
                    <br>

                    <!-- LOCATION -->
                    <div class="form-row">
                        <div class="form-group col">
                            <label for='zipcode'> Location </label>
                            <input type="text" class="form-control" placeholder="Zipcode" id="zip" name="zip" maxlength="5" onchange="getInfo(this.value)" required>
                        </div>
                        <div class="form-group col">
                            <input type="text" class="form-control" placeholder="City" id="city" name="city" readonly>
                        </div>
                        <div class="form-group col">
                            <input type="text" class="form-control" placeholder="State" maxlength="2" name="state" id="state" readonly>
                        </div>
                    </div> <!-- End form-row -->
                    <br>

                    <!-- DURATION -->
                    <div class='form-row form-input'>
                        <div class="col">
                            <label for='duration'> Date </label>
                            <input type="text" class="form-control" placeholder="Duration" id="duration" name="duration">
                        </div>
                    </div>
                    <div class='form-row form-input'>
                        <div class="col">
                            <input placeholder="Available" class="textbox-n form-control" type="text" onfocus="(this.type='date')" onblur="(this.type='text')" id="avail" name="avail">
                        </div>
                    </div>
                    <br>

                    <!-- DESCRIPTION -->
                    <div class="form-group">
                        <label for='description'> Description </label>
                        <textarea id="description" name="description" placeholder="Allergies, good with pets, special needs, etc..." class="form-control" rows="2" id="comment"></textarea>
                    </div>

                    <div class='upload-img'>
                        <label>Have a Pic?</label>
                        <input type="file" name="user_image" id="user_image" />
                        <input type="hidden" name="hidden_user_image" id="hidden_user_image" />
                        <span id="uploaded_image"></span>
                    </div>
                    <br>

                    <div align="center">
                        <input type="hidden" name="action" id="action" />
                        <input type="hidden" name="user_id" id="user_id" />
                        <input type="hidden" name="hair" id="hair" />
                        <input type="submit" name="button_action" id="button_action" class="btn btn-success" value="Insert" />
                        <a class="btn btn-danger" onclick="resetForm()">Reset</a>
                    </div>

                </form>
            </div> <!-- User-Collapse -->

            <hr>

            <div class='nav-link-wrapper'>
                <a class='dash-nav-link' href='editaccount.php?u=<?php echo $u; ?>'>Account Information <a/>
            </div>

            <div class='nav-link-wrapper'>
                <a class='dash-nav-link' href='../index.php'>Home <a/>
            </div>

            <div class='nav-link-wrapper'>
                <a class='dash-nav-link' href='../logout.php'>Logout <a/>
            </div>

        </div> <!-- col-3 -->

        <!-- User Dashboard -->
        <div class='col-md-9 dash'>
            <div class='dash-header'>Available Pets</div>

            <!-- Table -->
            <div class='table-wrapper'>
                <div id="user_table" class="table-responsive"> </div>
            </div>

            <!-- Modal -->
            <div class="modal fade text-center" id="theModal">
                <div class="modal-dialog">
                    <div class="modal-content"> </div>
                </div>
            </div>

        </div> <!-- col-md-9 -->
    </div> <!-- Row -->
</div> <!-- Container fluid -->


</body>
</html>

<script type="text/javascript">

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

    // CAT | DOG  BREED ==================================================================
    var dogs = [<?php echo '"'.implode('","', $column).'"' ?>];
    var cats = [<?php echo '"'.implode('","', $column2).'"' ?>];

    function setSelect(v) {

        var x = document.getElementById("breed");

        for (i = 0; i < x.length; ) {
            x.remove(x.length -1);
        }

        var a;

        if (v=='dogdd'){
            a = dogs;
        }

        else if (v=='catdd'){
            a = cats
        }

        for (i = 0; i < a.length; ++i) {
            var option = document.createElement("option");
            option.text = a[i];
            x.add(option);
        }
    }

    // Loads dog data first on page load because dog checkbox is ticked onload:
    function load() {
        setSelect('dogdd');
    }
    window.onload = load;

    // DATA HANDLING (CRUD FUNCITONALITIES) ===================================================
    $(document).ready(function(){

        // Fire Event:
        load_data();

        // Adding new data:
        $('#action').val("Insert");

        // When 'Add Record' button is clicked:
        $('#add').click(function(){

            // Reset (blank) form:
            $('#user_form')[0].reset();

            // Initialize image uploader with no files in queue:
            $('#uploaded_image').html('');

            // Change value of 'button_action' to Insert:
            $('#button_action').val("Insert");
        });

        // Loading page data:
        function load_data(page) {

            // Execute action.php (load)
            var action = "Load";

            $.ajax({
                // Where the request is sent:
                url:"action.php?u=<?php echo $id; ?>",

                // Post => Send data to the server:
                method:"POST",

                // The data to send to the server with the ajax request:
                data:{action:action, page:page},

                // Populate user_table with data:
                success:function(data) {
                    $('#user_table').html(data);
                }
            });
        } // Closing load_data()

        // CHANGING PAGES ===================================================================

        // When a new page is clicked (1 2 3 4 5):
        $(document).on('click', '.pagination_link', function(){

            // Page = (i) passed in:
            var page = $(this).attr("id");

            // Load new page with specified data:
            load_data(page);
        });

        // Value of session user's ID gets passed on action method POST from hidden input:
        $('#user_form').on('submit', function(event){

            // Prevent link from opening url:
            event.preventDefault();

            // General Information:
            var firstName = $('#name').val();
            var petCity = $('#city').val();
            var petState = $('#state').val();
            var petZip = $('#zip').val();
            var petGender = $('#gender').val();
            var getAge = $('#age').val();
            var getSize = $('#size').val();
            var petType = $('#type').val();
            var descrip = $('#description').val();
            var petColor = $('#color').val();
            var petHair = $('#hair').val();
            var petBreed = $('#breed').val();
            var petAvail = $('#avail').val();
            var petDuration = $('#duration').val();

            // Image FIle:
            var extension = $('#user_image').val().split('.').pop().toLowerCase();
            if(extension != '') {
                if(jQuery.inArray(extension, ['gif','png','jpg','jpeg']) == -1) {
                    alert("Invalid Image File");
                    $('#user_image').val('');
                    return false;
                }
            }

            if(firstName != '') {
                $.ajax( {
                    url:"action.php?u=<?php echo $id; ?>",
                    method:"POST",
                    data:new FormData(this),
                    contentType:false,
                    processData:false,
                    success:function(data) {
                        alert(data);
                        $('#user_form')[0].reset();
                        load_data();
                        $('#action').val("Insert");
                        $('#button_action').val("Insert");
                        $('#uploaded_image').html('');
                    }
                })
            }

            else {
                alert("Both Fields are Required");
            }
        });

        // UPDATE: If update button clicked...
        $(document).on('click', '.update', function(){
            var pet_info = $(this).attr("class");

            // POPULATE FORM FIELDS WITH EXISTING DATA -----------------------------------------------------
            // Ghetto... but works for now: Pass pet_info as array into class and use regex to sort results
            var pet_results = pet_info.match(/(?<=petinfo1\s+).*?(?=\spetinfo2)/gs);

            var user_id = $(this).attr("id");
            var name = pet_results[0];
            var age = pet_results[1];
            var gender = pet_results[2];
            var breed = pet_results[3];
            var color = pet_results[4];
            var hair = pet_results[5];
            var size = pet_results[6];
            var zip = pet_results[7];
            var city = pet_results[8];
            var state = pet_results[9];
            var duration = pet_results[10];
            var avail = pet_results[11];
            var description = pet_results[12];
            var image = pet_results[13];
            var type = pet_results[14];

            // ---------------------------------------------------------------------------------------------

            var action = "Fetch Single Data";

            $.ajax({
                url:"action.php",
                method:"POST",
                data:{user_id:user_id, action:action},
                dataType:"json",
                success:function(data) {
                    $('.collapse').collapse("show");

                    $('#type').val(type);
                    $('#name').val(name);
                    $('#city').val(city);
                    $('#state').val(state);
                    $('#zip').val(zip);
                    $('#age').val(age);
                    $('#size').val(size);
                    $('#gender').val(gender);
                    $('#type').val(data.type);
                    $('#description').val(description);
                    $('#color').val(color);
                    $('#hair').val(hair);
                    $('#breed').val(breed);
                    $('#avail').val(avail);
                    $('#duration').val(duration);

                    $('#uploaded_image').html(image);
                    $('#hidden_user_image').val(data.user_image);
                    $('#button_action').val("Edit");
                    $('#action').val("Edit");
                    $('#user_id').val(user_id);
                }
            });
        });

        // DELETE: If delete button is clicked...
        $(document).on('click', '.delete', function(){
            var user_id = $(this).attr("id");
            var action = "Delete";

            if(confirm("Are you sure you want to delete this?")) {
                $.ajax({
                    url:"action.php",
                    method:"POST",
                    data:{user_id:user_id, action:action},
                    success:function(data) {
                        alert(data);
                        load_data();
                    }
                });
            }

            else {
                return false;
            }
        });

    });

    // Reset Form:
    function resetForm() {
        document.getElementById("user_form").reset();
    }

</script>
