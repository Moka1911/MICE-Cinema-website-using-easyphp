<?php
  session_start();
  include_once 'assets/includes/Connection.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Homepage</title>
    <link href="<?php echo base_url().'assets\grocery_crud\css\ui\simple\homepage.css'?>" rel="stylesheet">
</head>

<body>


<?php
    if ($this->session->userdata('username')!=null and $this->session->userdata('userID')<1000000){
        echo '
    <nav>
        <div class="topnav">
          <img  id="logo_pic" src="';
          echo base_url().'assets/images/Mice logo final.JPG';
          echo '" alt="Mice logo">
          <a href="#Film" class="Log">Film</a>
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
                echo '" alt="logo">
              <a href="#Film" class="Log">Film</a>
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
            echo '" alt="logo">
          <a href="#Film" class="Log">Film</a>
          <div class="rightnav">';
           echo ' <a class="Log" href="';
           echo site_url('Main/login_page');
           echo '">Sign in</a>
          </div>
        </div>
    </nav>';
    }
?>

    <h1 id="book-now-header">Book Now</h1>
    <div class="home-page">
    <?php
        $sql2 = "Select * From film";
        $result = mysqli_query($conn,$sql2);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0){
            while($row = mysqli_fetch_assoc($result)){
                $Title= $row['Title'];
                echo '
                <div class="image-block">
                        
                    <a href="'.site_url('Main/booking_page').'?title='.$Title.'"><img src="'.base_url().$row['ImagePath'].'" alt="'.$Title.'"></a>

                    <h2>'.$Title.'</h2>
                </div>
                ';

            }
        }
    ?>
        
    </div>
</body>
</html>