<?php   

// database.php

 class Databases{  
     
      public $con;  
      public $error;  
     
      public function __construct() {
          
           $this->con = mysqli_connect("xxxxx.xxxxx.us-west-2.rds.amazonaws.com","user", "pass", "db");  
           
          if(!$this->con){  
                echo 'Database Connection Error ' . mysqli_connect_error($this->con);  
           }  
      }  
     
      public function required_validation($field) {
          
           $count = 0;  
           
           foreach($field as $key => $value) {
               
                if(empty($value)) {      
                     $count++;  
                     $this->error .= "<p>" . $key . " is required</p>";  
                }  
           }  
         
          if($count == 0) {    
                return true;  
           }  
      }  
      
     public function can_login($table_name, $where_condition) {
         
           $condition = '';  
           
           foreach($where_condition as $key => $value) {
               
                $condition .= $key . " = '".$value."' AND ";  
           }  

           /*This code will convert array to string like this :: input - array('id'=>'5') | output = id = '5' */
           $condition = substr($condition, 0, -5);  
           
           $query = "SELECT * 
                     FROM ".$table_name." 
                     WHERE " . $condition;  
          
           $result = mysqli_query($this->con, $query);  
           
           if(mysqli_num_rows ($result)) {  
                return true;  
           }  
           else {  
                $this->error = "Wrong Data";  
           }  
      }       
 }  
 ?>  
