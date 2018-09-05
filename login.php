<?php  
     include ('admin/database.php');  
     session_start();  

     $data = new Databases;  

     $message = '';  

     if(isset($_POST["login"]))  {  
          $field = array(  
               'email'        =>     $_POST["email"],  
               'password'     =>     $_POST["password"]  
          );  

          if($data->required_validation($field)) {
               if($data->can_login("users", $field)) {
                    $_SESSION["email"] = $_POST["email"];  
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

<?php
   include('inc/header.php'); 
?>

  <!-- Remaining Head Content --> 

  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css">

  <link rel="stylesheet" href="css/style.css">

</head>

<!-- Body Content --> 
<body>
  <form method="post">
	<div class="svgContainer">
		<div>
			<svg class="mySVG" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 200 200">
                
				<defs>
					<circle id="armMaskPath" cx="100" cy="100" r="100"/>	
				</defs>
				<clipPath id="armMask">
					<use xlink:href="#armMaskPath" overflow="visible"/>
				</clipPath>
                
				<circle cx="100" cy="100" r="100" fill="#d3ede5"/>
				
                <!-- Body --> 
                <g class="body">
                    
                    <!-- Bottom half of body --> 
					<path fill="#dedede" d="M193.3,135.9c-5.8-8.4-15.5-13.9-26.5-13.9H151V72c0-27.6-22.4-50-50-50S51,44.4,51,72v50H32.1 c-10.6,0-20,5.1-25.8,13l0,78h187L193.3,135.9z"/>
					
                    <!-- Top half of body --> 
                    <path fill="#dedede" stroke="#3A5E77" stroke-width="3" stroke-linecap="round" stroke-linejoinn="round" d="M193.3,135.9 c-5.8-8.4-15.5-13.9-26.5-13.9H151V72c0-27.6-22.4-50-50-50S51,44.4,51,72v50H32.1c-10.6,0-20,5.1-25.8,13"/>
					
                    <!-- Round spot on chest --> 
                    <path fill="#fff" d="M100,156.4c-22.9,0-43,11.1-54.1,27.7c15.6,10,34.2,15.9,54.1,15.9s38.5-5.8,54.1-15.9 C143,167.5,122.9,156.4,100,156.4z" stroke-width=".5" stroke="#fff"/>
				</g>
                
                <!-- Left Ear --> 
				<g class="earL">
					<g class="outerEar" fill="#dedede" stroke="#3a5e77" stroke-width="2.5">
				
						<path d="M55,55 Q40,10, 75,32" stroke-linecap="round" stroke-linejoinn="round"/>
					</g>
                    
                    
                    <!-- Ear hair --> 
					<g class="earHair">
						<rect x="51" y="64" fill="#dedede" width="15" height="35"/>
						<path d="M53.4 62.8C48.5 67.4 45 72.2 42.8 77c3.4-.1 6.8-.1 10.1.1-4 3.7-6.8 7.6-8.2 11.6 2.1 0 4.2 0 6.3.2-2.6 4.1-3.8 8.3-3.7 12.5 1.2-.7 3.4-1.4 5.2-1.9" fill="#dedede" stroke="#3a5e77" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
					</g>
				</g>
                
                <!-- Right Ear --> 
				<g class="earR">
					<g class="outerEar" fill="#dedede" stroke="#3a5e77" stroke-width="2.5">
                        
                       <path d="M129,32 Q160,10, 147,55" stroke-linecap="round" stroke-linejoinn="round"/>
                    </g>
                    
                    <!-- Ear hair --> 
					<g class="earHair">
						<rect x="131" y="64" fill="#dedede" width="20" height="35"/>
						<path d="M148.6 62.8c4.9 4.6 8.4 9.4 10.6 14.2-3.4-.1-6.8-.1-10.1.1 4 3.7 6.8 7.6 8.2 11.6-2.1 0-4.2 0-6.3.2 2.6 4.1 3.8 8.3 3.7 12.5-1.2-.7-3.4-1.4-5.2-1.9" fill="#dedede" stroke="#3a5e77" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
					</g>
				</g>
                
                <!-- Chin --> 
				<path class="chin" d="M84.1 121.6c2.7 2.9 6.1 5.4 9.8 7.5l.9-4.5c2.9 2.5 6.3 4.8 10.2 6.5 0-1.9-.1-3.9-.2-5.8 3 1.2 6.2 2 9.7 2.5-.3-2.1-.7-4.1-1.2-6.1" fill="none" stroke="#3a5e77" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
				
                <!-- Round spot on face --> 
                <path class="face" fill="#dedede" d="M134.5,46v35.5c0,21.815-15.446,39.5-34.5,39.5s-34.5-17.685-34.5-39.5V46"/>
				
                <!-- Hair --> 
                <path class="hair" fill="#dedede" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M81.457,27.929 c1.755-4.084,5.51-8.262,11.253-11.77c0.979,2.565,1.883,5.14,2.712,7.723c3.162-4.265,8.626-8.27,16.272-11.235 c-0.737,3.293-1.588,6.573-2.554,9.837c4.857-2.116,11.049-3.64,18.428-4.156c-2.403,3.23-5.021,6.391-7.852,9.474"/>
				
                
                <!-- Eyebrow --> 
                <g class="eyebrow">
                    
                    <!-- Area above eyebrow --> 
					<path fill="#dedede" d="M138.142,55.064c-4.93,1.259-9.874,2.118-14.787,2.599c-0.336,3.341-0.776,6.689-1.322,10.037 c-4.569-1.465-8.909-3.222-12.996-5.226c-0.98,3.075-2.07,6.137-3.267,9.179c-5.514-3.067-10.559-6.545-15.097-10.329 c-1.806,2.889-3.745,5.73-5.816,8.515c-7.916-4.124-15.053-9.114-21.296-14.738l1.107-11.768h73.475V55.064z"/>
					
                    <!-- Eyebrow itself --> 
                    <path fill="#dedede" stroke="#3A5E77" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M63.56,55.102 c6.243,5.624,13.38,10.614,21.296,14.738c2.071-2.785,4.01-5.626,5.816-8.515c4.537,3.785,9.583,7.263,15.097,10.329 c1.197-3.043,2.287-6.104,3.267-9.179c4.087,2.004,8.427,3.761,12.996,5.226c0.545-3.348,0.986-6.696,1.322-10.037 c4.913-0.481,9.857-1.34,14.787-2.599"/>
				</g>
                
                <!-- Left eye --> 
				<g class="eyeL">
					<circle cx="85.5" cy="78.5" r="3.5" fill="#3a5e77"/>
					<circle cx="84" cy="76" r="1" fill="#fff"/>
				</g>
                
                <!-- Right eye --> 
				<g class="eyeR">
					<circle cx="114.5" cy="78.5" r="3.5" fill="#3a5e77"/>
					<circle cx="113" cy="76" r="1" fill="#fff"/>
				</g>
                
                <!-- Nose --> 
                <g class="nose">
                    <path d="M 97.7, 85.5 h 4.7 c 1.9 0 3 2.2 1.9 3.7 l -2.3 3.3 c -.9 1.3 -2.9 1.3-3.8 0 l -2.3 -3.3 c -1.3 -1.6 -.2 -3.7 1.8 -3.7 z" fill="#3a5e77"/>
                    <path d="M 100 91 L 100 97" stroke="#3a5e77" stroke-width="2" />
                    
                    <!-- R-Whiskers --> 
                    <path d="M 110 87 Q125,83 140, 87" fill="none" stroke="#3a5e77" stroke-width=".80" />
                    <path d="M 111.5 88.5 Q125,87 141, 93" fill="none" stroke="#3a5e77" stroke-width=".80" />
                    <path d="M 111 90.5 Q125,88 142, 104" fill="none" stroke="#3a5e77" stroke-width=".80" />
                    
                    <!-- L-Whiskers --> 
                    <path d="M 89 87 Q64,85 59, 89" fill="none" stroke="#3a5e77" stroke-width=".80" />
                    <path d="M 87.5 88.5 Q64,87 57, 96" fill="none" stroke="#3a5e77" stroke-width=".80" />
                    <path d="M 86.5 90.5 Q64,90 58, 111" fill="none" stroke="#3a5e77" stroke-width=".80" />
                </g>
                
                <!-- Arms --> 
                <g class="arms" clip-path="url(#armMask)">
                    
                    <!-- Left Arm --> 
					<g class="armL">
                        
                        <!-- Paw --> 
						<path fill="#fff" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.80" 
                        d="M 121.3 97.4 L 105 58.7 l 30.8 -10.4 Q 145 42 155 49 l -10 4 l 10 -4 Q 170 50 177 63 l -15 6 l 13 -6 Q 189 82 175 91 l -13 2 l 10 -1 Q 150 115 130 91"/>
                        
                        <!-- Sleeve --> 
                        <path fill="#dedede" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M123.5 96.8c-41.4 14.9-84.1 30.7-108.2 35.5L1.2 80c33.5-9.9 71.9-16.5 111.9-21.8"/>
						
                        <!-- Cuff --> 
                        <path fill="#dedede" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M108.5 59.4c7.7-5.3 14.3-8.4 22.8-13.2-2.4 5.3-4.7 10.3-6.7 15.1 4.3.3 8.4.7 12.3 1.3-4.2 5-8.1 9.6-11.5 13.9 3.1 1.1 6 2.4 8.7 3.8-1.4 2.9-2.7 5.8-3.9 8.5 2.5 3.5 4.6 7.2 6.3 11-4.9-.8-9-.7-16.2-2.7M94.5 102.8c-.6 4-3.8 8.9-9.4 14.7-2.6-1.8-5-3.7-7.2-5.7-2.5 4.1-6.6 8.8-12.2 14-1.9-2.2-3.4-4.5-4.5-6.9-4.4 3.3-9.5 6.9-15.4 10.8-.2-3.4.1-7.1 1.1-10.9M97.5 62.9c-1.7-2.4-5.9-4.1-12.4-5.2-.9 2.2-1.8 4.3-2.5 6.5-3.8-1.8-9.4-3.1-17-3.8.5 2.3 1.2 4.5 1.9 6.8-5-.6-11.2-.9-18.4-1 2 2.9.9 3.5 3.9 6.2"/>
					</g>
                    
                    <!-- Right Arm --> 
					<g class="armR">
                        
                        <!-- Paw --> 
						<path fill="#fff" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="1.8" d="
                            M 265.4 97.3 L 281 65 l -25.8 -10.4Q 242 40 230 46l 10 4l -10 -4Q 215 47 208 58 l 18 4 l -19 -4 Q 196 80 216 85l 13 2l -15 -2Q 220 98 265 94
                            "/>
						 
                        <path fill="#fff" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" stroke-width="2.5" d=""/>				
                        
                        
                        <!-- Sleeve --> 
                        <path fill="#dedede" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M263.3 96.7c41.4 14.9 84.1 30.7 108.2 35.5l14-52.3C352 70 313.6 63.5 273.6 58.1"/>
						
                        <!-- Cuff --> 
                        <path fill="#dedede" stroke="#3a5e77" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M278.2 59.3l-18.6-10 2.5 11.9-10.7 6.5 9.9 8.7-13.9 6.4 9.1 5.9-13.2 9.2 23.1-.9M284.5 100.1c-.4 4 1.8 8.9 6.7 14.8 3.5-1.8 6.7-3.6 9.7-5.5 1.8 4.2 5.1 8.9 10.1 14.1 2.7-2.1 5.1-4.4 7.1-6.8 4.1 3.4 9 7 14.7 11 1.2-3.4 1.8-7 1.7-10.9M314 66.7s5.4-5.7 12.6-7.4c1.7 2.9 3.3 5.7 4.9 8.6 3.8-2.5 9.8-4.4 18.2-5.7.1 3.1.1 6.1 0 9.2 5.5-1 12.5-1.6 20.8-1.9-1.4 3.9-2.5 8.4-2.5 8.4"/>
					</g>				
				</g>
                
                <!-- Mouth (Not fully working) --> 
				<g class="mouth">
					
                    <path class="mouthBG" fill="#3a5e77" d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z"/>
                    
					<path style="display: none;" class="mouthSmallBG" fill="#617E92" d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z"/>
                    
					<path style="display: none;" class="mouthMediumBG" d="M95,104.2c-4.5,0-8.2-3.7-8.2-8.2v-2c0-1.2,1-2.2,2.2-2.2h22c1.2,0,2.2,1,2.2,2.2v2 c0,4.5-3.7,8.2-8.2,8.2H95z"/>
                    
					<path style="display: none;" class="mouthLargeBG" d="M100 110.2c-9 0-16.2-7.3-16.2-16.2 0-2.3 1.9-4.2 4.2-4.2h24c2.3 0 4.2 1.9 4.2 4.2 0 9-7.2 16.2-16.2 16.2z" fill="#617e92" stroke="#3a5e77" stroke-linejoin="round" stroke-width="2.5"/>
					
                    <defs>
						<path id="mouthMaskPath" d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z"/>
					</defs>
					
                    <clipPath id="mouthMask">
						<use xlink:href="#mouthMaskPath" overflow="visible"/>
					</clipPath>
					
                    <g clip-path="url(#mouthMask)">
						<g class="tongue">
							<circle cx="100" cy="107" r="8" fill="#cc4a6c"/>
							<ellipse class="tongueHighlight" cx="100" cy="100.5" rx="3" ry="1.5" opacity=".1" fill="#fff"/>
						</g>
					</g>
					
                    <path clip-path="url(#mouthMask)" class="tooth" style="fill:#FFFFFF;" d="M106,97h-4c-1.1,0-2-0.9-2-2v-2h8v2C108,96.1,107.1,97,106,97z"/>
					
                    <path class="mouthOutline" fill="none" stroke="#3A5E77" stroke-width="2.5" stroke-linejoin="round" d="M100.2,101c-0.4,0-1.4,0-1.8,0c-2.7-0.3-5.3-1.1-8-2.5c-0.7-0.3-0.9-1.2-0.6-1.8 c0.2-0.5,0.7-0.7,1.2-0.7c0.2,0,0.5,0.1,0.6,0.2c3,1.5,5.8,2.3,8.6,2.3s5.7-0.7,8.6-2.3c0.2-0.1,0.4-0.2,0.6-0.2 c0.5,0,1,0.3,1.2,0.7c0.4,0.7,0.1,1.5-0.6,1.9c-2.6,1.4-5.3,2.2-7.9,2.5C101.7,101,100.5,101,100.2,101z"/>
				</g>
			</svg>
		</div>
	</div>
    
    <!-- Form -->

      
    <div class="inputGroup inputGroup1">
		<label for="email1">Email (test@repaw.io)</label>
		<input type="text" name="email" id="email" class="email" maxlength="256"/>
        <span class="indicator"></span>
	</div>
	
    <div class="inputGroup inputGroup2">
		<label for="password">Password (password)</label>
		<input type="password" name="password" id="password" class="password" />
	</div>
      
    <div class="inputGroup inputGroup3">
		<button type="submit" id="login" name="login" >Log in</button>
	</div>
    
</form>

<!-- Scripts --> 
<script src='https://cdnjs.cloudflare.com/ajax/libs/gsap/1.20.3/TweenMax.min.js'></script>
<script  src="js/index.js"></script>

<!-- Remaining body content here --> 
    
<?php
    /* <footer> | </body> | </html> */
    include('inc/footer.php'); 
?>
