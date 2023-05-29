
<?php
session_start();
include_once 'assets/includes/Connection.inc.php'
?>
<!DOCTYPE html>
<head>
    <title>Profile page</title>
    <link href="<?php echo base_url().'assets\grocery_crud\css\ui\simple\profile-fake.css'?>" rel="stylesheet">
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
            echo '" class="Log">Films</a>
          <a id="manager" class="Log" href="';
          echo site_url('Main/film');
          echo '#manager">Manager</a>
          <div class="rightnav">';
            echo '<a class="Log" href="';
            echo site_url('Main/logout');
            echo '">Log out</a>
          </div>
        </div>
    </nav>';
    $User_ID = $this->session->userdata('userID');
    $sql = "Select * From staff Where EmployeeNo = $User_ID";
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
    else {
        site_url('Main/index');
    }
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
              echo '<a class="Log" href="';
              echo site_url('Main/logout');
              echo '">Log out</a>
              </div>
            </div>
        </nav>';

    $User_ID = $this->session->userdata('userID');
    $sql = "Select * From member Where MemberID = $User_ID";
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
    else {
        site_url('Main/index');
    }
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
            <div class="rightnav">
                <a href="./LoginPage.php">Sign in</a>
            </div>
        </div>
    </nav>';
    }
?>

    <h1 id="account-header">My Account</h1>
    <img  id="account_pic" style="margin-left: 42.5%;" src="<?php echo base_url().'assets/images/account.png'?>" alt="profile picture" >

    <center><h2>Your Bookings </h2></center>
    <center><?php echo $output; ?></center>
    <div class="big_container">  
            <div class="headers" id="special">
                <form action="<?php echo site_url('Main/Update_info')?>" method="POST">
                    <center><h2>Account Details</h2></center>
                    <hr>
                    <div class="sub_block">
                        <h4>First Name</h3>
                        <input type="text" name="First_name" placeholder="<?php echo $First_name?>" value="<?php echo $First_name?>">
                    </div>
                    <div class="sub_block">
                        <h4>Last Name</h3>
                        <input type="text" name="Last_name" placeholder="<?php echo $Last_name?>" value="<?php echo $Last_name?>">
                    </div>
                    <div class="sub_block">
                        <h4>Date of Birth</h3>
                        <input type="date" name="Date_of_Birth" min="1978-03-28" max="2022-03-28" value="<?php echo $DoB?>">
                    </div>
                    <div class="sub_block">
                        <h4>Gender</h3>
                        <select  name="Gender" class="box">
                            <option selected><?php echo $Gender?></option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="sub_block">
                        <h4>Address</h3>
                        <input style="overflow: auto;" type="text" name="Address" placeholder="<?php echo $Address?>" value="<?php echo $Address?>">
                    </div>
                    <div class="sub_block">
                        <h4>Mobile Number</h3>
                        <input type="text" name="Mobile_Number" placeholder="<?php echo $Phone?>" value="<?php echo $Phone?>">
                    </div>
                    <button type="submit" name="insert">Submit</button>
                </form>
            </div>
    </div>
</body>