<?php
  session_start();
  include_once 'assets/includes/Connection.inc.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager page</title>
    <link href="<?php echo base_url().'assets\grocery_crud\css\ui\simple\manager.css'?>" rel="stylesheet">
    <?php 
        foreach($css_files as $file): ?>
            <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
        <?php endforeach; ?>
        <?php foreach($js_files as $file): ?>
            <script src="<?php echo $file; ?>"></script>
        <?php endforeach; ?>
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
          echo '" class="Log">Film</a>
          <a id="manager" class="Log" href="#manager">Manager</a>
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
                echo '" class="Log">Film</a>
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
          echo '" class="Log">Film</a>
          <div class="rightnav">';
           echo ' <a class="Log" href="';
           echo site_url('Main/login_page');
           echo '">Sign in</a>
          </div>
        </div>
    </nav>';
    }
?>

<div class="container1">
    <nav>
            <ul>
                <li>
                    <a href="<?php echo site_url('Main/film')?>"> Film</a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/screen')?>"> Screen</a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/showing')?>"> Showing</a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/performance')?>"> Performance</a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/booking')?>"> Booking </a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/staff')?>"> Staff</a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/members')?>">Members</a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/Cinema')?>">Cinema</a>
                </li>
                <li>
                    <a href="<?php echo site_url('Main/finance_report')?>">Finance report</a>
                </li>
            </ul>
    </nav>
        <center><?php echo $output;?></center>
</div>





















</body>
