<?php
  session_start();
  include_once 'assets/includes/Connection.inc.php';
?>

<!DOCTYPE html>
<head>
    <title>Confirmation page</title>
    <link href="<?php echo base_url().'assets\grocery_crud\css\ui\simple\confirmation-page.css'?>" rel="stylesheet">
</head>
<body>
<?php
    if ($this->session->userdata('username')!=null and $this->session->userdata('userID')<1000000){
        echo '
    <nav>
        <div class="topnav">
          <img  id="logo_pic" src="';
          echo base_url().'assets/images/Mice logo final.JPG';
          echo '" alt="MICE logo">
          <a href="';
            echo site_url('Main/index');
            echo '" class="Log">Films</a>
          <a id="manager" class="Log" href="';
          echo site_url('Main/film');
          echo '#manager">Manager</a>
          <div class="rightnav">';
            echo ' <a href="';
            echo site_url('Main/user_bookings');
            echo '"><img src="';
            echo base_url().'assets/images/account.png';
            echo '" id="Profile_icon" alt="My Profile"></a>';
            echo '<a class="Log" href="';
            echo site_url('Main/logout');
            echo '">Log out</a>
            </div>
        </div>
    </nav>';
    }
    elseif($this->session->userdata('username')!=null and $this->session->userdata('userID')>=1000000){
        echo '
        <nav>
            <div class="topnav">
                <img  id="logo_pic" src="';
                echo base_url().'assets/images/Mice logo final.JPG';
                echo '" alt="MICE logo">
                <a href="';
                echo site_url('Main/index');
                echo '" class="Log">Films</a>
              <div class="rightnav">';
                echo ' <a href="';
                echo site_url('Main/user_bookings');
                echo '"><img src="';
                echo base_url().'assets/images/account.png';
                echo '" id="Profile_icon" alt="My Profile"></a>';
                echo '<a class="Log" href="';
                echo site_url('Main/logout');
                echo '">Log out</a>
              </div>
            </div>
        </nav>';

    }
    else{
        echo'    
    <nav>
        <div class="topnav">
            <img  id="logo_pic" src="';
            echo base_url().'assets/images/Mice logo final.JPG';
            echo '" alt="MICE logo">
            <a href="';
            echo site_url('Main/index');
            echo '" class="Log">Films</a>
          <div class="rightnav">';
           echo ' <a class="Log" href="';
           echo site_url('Main/login_page');
           echo '">Sign in</a>
          </div>
        </div>
    </nav>';
    }

    $User_ID = $this->session->userdata('userID');
    $User_name = $this->session->userdata('username');
    if ($User_ID >= 1000000){
        $sql = "Select * From member Where MemberID = $User_ID";
    }
    elseif($User_ID < 1000000){
        $sql = "Select * From member Where MUsername = '$User_name' and is_staff = '1';";
    }
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $First_name = $row['first_name'];
            $Last_name = $row['last_name'];
            $Address = $row['Address'];
            $Phone = $row['PhoneNo'];
            $DoB = $row['DoB'];
            $Gender = $row['Gender'];
        }
    }
?>


    <div class="container">
            <?php
                if(isset($error)){
                    echo '<h1>'.$error.'</h1>';
                }
                else {
                    echo '      <h1> Enjoy your film at MICE</h1>
                                <h3> Thanks '.$First_name.', your booking has been successful</h3>
                                <br>
                                <h3> Your booking confirmation along with your virtual ticket have been sent to your email</h3>';
                }
            ?>

    </div>
    
</body>