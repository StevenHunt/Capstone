<?php
    include ('/inc/header.php');
?>

<!-- Content --> 
<body> 

    <p id="demo">Launching in </p>

<script>
    
    // Set the date we're counting down to
    var countDownDate = new Date("Oct 19, 2019 12:00:00").getTime();

    // Update the count down every 1 second
    var x = setInterval(function() {

        // Todays Date:
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Ouput
        document.getElementById("demo").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";

        // If the count down is over, write some text 
        if (distance < 0) {
            clearInterval(x);
            document.getElementById("demo").innerHTML = "Launched!";
        }
    }, 1000);
    
</script>

<?php  
    
    /* Closes body and html tag */
    include ('/inc/footer.php'); 
?>