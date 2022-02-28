<div class="form signup"><!-- Registration Form -->
        <span class="title">Registration</span>

        <form action="#">
            <div class="input-field">
                <input type="text" placeholder="Enter your name" required>
                <i class="uil uil-user"></i>
            </div>
            <div class="input-field">
                <input type="text" placeholder="Enter your email" required>
                <i class="uil uil-envelope icon"></i>
            </div>
            <div class="input-field">
                <input type="password" class="password" placeholder="Create a password" required>
                <i class="uil uil-lock icon"></i>
            </div>
            <div class="input-field">
                <input type="password" class="password" placeholder="Confirm a password" required>
                <i class="uil uil-lock icon"></i>
                <i class="uil uil-eye-slash showHidePw"></i>
            </div>

            <div class="checkbox-text">
                <div class="checkbox-content">
                    <input type="checkbox" id="sigCheck">
                    <label for="sigCheck" class="text">Remember me</label>
                </div>
                        
                <a href="#" class="text">Forgot password?</a>
            </div>

            <div class="input-field button">
                <input type="button" class="uppercase gold-font" value="Login Now">
            </div>
        </form>

        <div class="login-signup">
            <span class="text">Not a member?
                <a href="#" class="text login-link">Signup now</a>
            </span>
        </div>
    </div><!-- Registration Form -->
</div>

<?php 
    if(isset($_POST['Submit'])){
        $First_name = $_POST['First_name'];
        $Last_name = $_POST['Last_name'];
        $Email = $_POST['Email'];
        $Password = md5($_POST['Password']);
        $Cpassword = md5($_POST['Confirm_password']);

    //    $sql = "INSERT INTO test_user (FNAME)
    //    VALUES ('$First_name')";

    //     if ($conn->query($sql) === TRUE) {
    //         echo "New record created successfully";
    //     } else {
    //         echo "Error: " . $sql . "<br>" . $conn->error;
    //     }
        
    //     $conn->close();
    }
?>

