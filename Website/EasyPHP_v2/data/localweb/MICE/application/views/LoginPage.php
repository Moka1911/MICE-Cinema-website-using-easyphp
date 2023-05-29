<?php
  session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Sign in</title>
    <link href="<?php echo base_url().'assets\grocery_crud\css\ui\simple\index.css'?>" rel="stylesheet">
  </head>

  <body>
      <nav>
          <div class="topnav">
            <img  id="logo_pic" src="<?php echo base_url().'assets/images/Mice logo final.JPG'?>" alt="logo">
            <a href="<?php echo site_url('Main/index')?>">Films</a>
            <a id="hidden" href="#manager">Manager</a>
            <a href="#sign-in" id="hidden">Sign in</a>
          </div>
      </nav>

        <div class="signin-page">
          <h2>SIGN IN</h2> 
          <hr>
          <form action="<?php echo site_url('Main/Login_Validation')?>" method="POST">
            <h3>Email</h3>
            <input type="text" name="username" id="username-field" class="login-form-field" placeholder="Username">
            <span class ="error"><?php  echo form_error('username'); ?></span>

            <h3>Password</h3>
            <input type="Password" name="password" id="password-field" placeholder="Password">
            <span class ="error"><?php  echo form_error('password'); ?></span>

            <br><input type="checkbox" id="show-pass" onclick="myFunction()"><span id="checkbox-text">Show Password</span></br>
            <br><button type="submit" name="insert">Login</button></br>
            <?php 
              echo $this->session->flashdata("error");
            ?>
          </form>
        </div>
      

      <script>
        function myFunction() {
        var x = document.getElementById("password-field");
        if (x.type === "password") {
           x.type = "text";
        } 
        else {
           x.type = "password";
        }
        }
      </script>

  </body>
</html>




