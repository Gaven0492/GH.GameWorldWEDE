<?php
/*============================================================================*/
/*=================== created 11-02-2026 | SDN: 96957 Gmik ===================*/
/*============================================================================*/


include("Inc/functions.php");
HTMLhead();
HTMLnavBar();
?>

<section class="container" id="container">
    <div class="formContainer signUp">
        <form action="" method="POST">

            <h1>Contact me using: </h1>
            <div class="socials">
                <ul>
                    <li><a href="#"><i class="fab fa-google icon"></i></a></li>
                    <li><a href="#"><i class="fab fa-facebook-f icon"></i></a></li>
                    <li><a href="#"><i class="fab fa-github icon"></i></a></li>
                    <li><a href="#"><i class="fab fa-linkedin-in icon"></i></a></li>
                </ul>
            </div>

            <h1>Or using the form below: </h1>

            <input type="text" id="fname" name="fname" placeholder="First name" >
            <input type="text" id="lname" name="lname" placeholder="Last name" >
            <input type="text" id="address" name="address" placeholder="Address">
            <input type="email" id="email" name="email" placeholder="Email">
            <input type="text" id="message" name="message" placeholder="Message">

            <div class="formButtons">
                <button name="submit" id="submit" class="submitButton"><span>Submit</span></button>
                <button name="reset" id="reset" class="resetButton"><span>Reset</span></button>
            </div>
        </form>
    </div>
</section>            


<?php
HTMLfoot();
?>