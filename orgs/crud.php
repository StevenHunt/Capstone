<?php

// Check login satus:
include ('../php_includes/check_login_status.php');

// Create, Read, Update, and Delete (CRUD) Class:
Class Crud {

    public $connect;
    private $host = "localhost";
    private $username = 'uname';
    private $password = 'password';
    private $database = 'test';

    // Constructor:
    function __construct() {
        $this->database_connect();
    }

    // Connect to DB:
    public function database_connect() {
        $this->connect = mysqli_connect($this->host, $this->username, $this->password, $this->database);
    }

    // Execute passed in query:
    public function execute_query($query) {
        return mysqli_query($this->connect, $query);
    }

    // Populate data into table:
    public function get_data_in_table($query) {

        // Initializing variables:
        $output = '';

        // Result => passed in query:
        $result = $this->execute_query($query);

        $output .= '
            <div class="container-fluid">
                <div class="row">
        ';

        // If there is data:
        if(mysqli_num_rows($result) > 0) {

            while($row = mysqli_fetch_object($result)) {

                $output .= '
                <div class="col-md-4 card-wrapper">
                    <div class="card shadow p-3 mb-5 bg-white rounded dash-card">

                        <div class="card-header text-center"> '
                            .$row->name. '
                        </div>
                        <br>

                        <div class="card-img">
                            <img src="upload/' . $row->image. '" class="center" height="120px" width="150px" />
                        </div>
                        <br>
                        <br>

                        <div class="card-info">
                            <b>Age:</b> ' . $row->age . '
                        </div>

                        <div class="card-info">
                            <b>Gender:</b> ' . $row->gender . '
                        </div>

                        <div class="card-info">
                            <b>Size:</b> ' . $row->size . '
                        </div>

                        <div class="card-footer text-center">
                            <a class="btn btn-info btn-xs in-line card-btn" href="fetch_info.php?pet=' . $row->id. '" data-target="#theModal" data-toggle="modal" data-backdrop="static" data-keyboard="false">Info</a>
                            <a class="

                              petinfo1 '.$row->name.' petinfo2
                              petinfo1 '.$row->age.' petinfo2
                              petinfo1 '.$row->gender.' petinfo2
                              petinfo1 '.$row->breed.' petinfo2
                              petinfo1 '.$row->color.' petinfo2
                              petinfo1 '.$row->hair.' petinfo2
                              petinfo1 '.$row->size.' petinfo2
                              petinfo1 '.$row->zip.' petinfo2
                              petinfo1 '.$row->city.' petinfo2
                              petinfo1 '.$row->state.' petinfo2
                              petinfo1 '.$row->duration.' petinfo2
                              petinfo1 '.$row->avail.' petinfo2
                              petinfo1 '.$row->description.' petinfo2
                              petinfo1 '.$row->image.' petinfo2
                              petinfo1 '.$row->type.' petinfo2

                              btn btn-warning btn-xs in-line update card-btn" name="update" id="'.$row->id.'" >Update</a>
                            <a class="btn btn-danger btn-xs in-line delete card-btn" type="button" name="delete" id="'.$row->id.'" >Delete</a>
                        </div>
                    </div>
                </div>
                ';
            }
        }

        else {

            $output .= '
                <div class="no-data-found">
                    <h1> No Data Found </h1>
                </div>
            ';
        }

        $output .= '

            </div>
        ';

        // Return the output produced:
        return $output;
    }

    // Upload pet_image and return new name of image:
    function upload_file($file) {

        if(isset($file)) {

            // Get the file externsion (explode the string at the '.')
            $extension = explode('.', $file["name"]);

            // New file name: (random 1-10 digit number).file_extension
            $new_name = rand() . '.' . $extension[1];

            // Filepath where image file will be stored on the server:
            $destination = './upload/' . $new_name;

            // Move file to specified destination:
            move_uploaded_file($file['tmp_name'], $destination);

            // Return the newly created name:
            return $new_name;
        }
    }

    // Making pagination link:
    function make_pagination_link($query, $record_per_page) {

        // Initializing output:
        $output = '';

        // Used to return all pets from specific user_id:
        $result = $this->execute_query($query);

        // Counts the amount of records this user has:
        $total_records = mysqli_num_rows($result);

        // Creates the amount of pages needed (total recrods / number of records chosen to display per page)
        $total_pages = ceil($total_records/$record_per_page);

        // Create links for each page:
        for($i=1; $i<=$total_pages; $i++) {
            $output .= '<span class="pagination_link" style="cursor:pointer; padding: 5px; font-weight: bold;" id="'.$i.'">'.$i.'</span>';
        }

        // Return links:
        return $output;
    }

} // Close CRUD Class

?>
