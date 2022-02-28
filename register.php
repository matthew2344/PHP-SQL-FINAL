<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="dist/css/style.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="dist/css/registration.css">
    <?php 
    // include('connection.php')
    ?> 
</head>

<!-- navigation section -->

<?php include('nav.php')?>

<!-- navigation section -->

<body>
    
    <main>
        
        <div class="form-container"> <!-- form-container -->
            
            <!-- form-register -->
            <?php include('form-register.php') ?>
            <!-- form-register -->

        </div><!-- form-container -->
        

    </main>

    <!-- footer section -->

    <?php include('footer.php')?>

    <!-- footer section -->
    <script src="dist/script/script.js"></script>
    
</body>


</html>
