<?php
  session_start();
  include_once 'assets/includes/Connection.inc.php';
?>

<!DOCTYPE html>
<html>
    <head>
    <title>Homepage</title>
    <link href="<?php echo base_url().'assets\grocery_crud\css\ui\simple\finance.css'?>" rel="stylesheet">
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
<hr>
<center><h1>Finance Report</h1></center>
<hr>
    <div class="container1">
        <center><table border="3px" class="table"></center>
            <tr>
                <td>Title</td>
                <td>ShowingNo</td>
                <td>Tickets_sold</td>
                <td>SeatPrice</td>
                <td>Total income</td>
            </tr>
            
            <?php
                $sql = "Select Title,ShowingNo,Tickets_Sold,SeatPrice,Tickets_Sold*SeatPrice As 'Total income'
                From screen natural join showing natural join Film natural join Performance natural join booking natural join (Select ShowingNo,sum(NoofSeats) As 'Tickets_Sold'
                                                                                 From booking Group by showingNo) As T2
                group by ShowingNo,Title;";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
            
                if ($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>';
                        echo '<td>'.$row['Title'].'</td>';
                        echo '<td>'.$row['ShowingNo'].'</td>';
                        echo '<td>'.$row['Tickets_Sold'].'</td>';
                        echo '<td>'.$row['SeatPrice'].'$</td>';
                        echo '<td>'.$row['Total income'].'$</td>';
                        echo '</tr>';
                    }
                }
            ?>
            
        </table>
        <br>
        <hr>
        <center><h1>Screen Report</h1></center>
        <hr>
        <br>
        <center><h2>All Screen Report</h2></center>
        <center><table border="3px" class="table"></center>
            <tr>
                <td>Cinema ID</td>
                <td>Cinema Name</td>
                <td>Screen No</td>
                <td>SeatPrice</td>
                <td>No of showings displayed on screen</td>
            </tr>
            
            <?php
                $sql = "Select CinemaID, CName, ScreenNo, SeatPrice, count(ShowingNo) as 'displayed showings'
                From cinema natural join Screen natural join Showing
                Group by CinemaID, CName, ScreenNo";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
            
                if ($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>';
                        echo '<td>'.$row['CinemaID'].'</td>';
                        echo '<td>'.$row['CName'].'</td>';
                        echo '<td>'.$row['ScreenNo'].'</td>';
                        echo '<td>'.$row['SeatPrice'].'$</td>';
                        echo '<td>'.$row['displayed showings'].'</td>';
                        echo '</tr>';
                    }
                }
            ?>
            
        </table>
        <br>
        <center><h2>Active Screen Report</h2></center>
        <center><table border="3px" class="table"></center>
            <tr>
                <td>Cinema Name</td>
                <td>Screen Number</td>
                <td>Tickets Sold</td>
                <td>SeatPrice</td>
                <td>Total money gained per screen</td>
            </tr>
            
            <?php
                $sql = "Select CName,ScreenNo,sum(Tickets_Sold) as 'Tickets',SeatPrice, sum(Tickets_Sold*SeatPrice) as 'Money gained'
                From Screen natural join 
                (Select CinemaID,CName,ScreenNo,ShowingNo,sum(NoofSeats) As 'Tickets_Sold'
                From booking natural join performance natural join film natural join showing natural join screen natural join cinema
                Group by ScreenNo,showingNo) as T1
                group by CName,ScreenNo,SeatPrice;";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
            
                if ($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>';
                        echo '<td>'.$row['CName'].'</td>';
                        echo '<td>'.$row['ScreenNo'].'</td>';
                        echo '<td>'.$row['Tickets'].'</td>';
                        echo '<td>'.$row['SeatPrice'].'$</td>';
                        echo '<td>'.$row['Money gained'].'$</td>';
                        echo '</tr>';
                    }
                }
            ?>
            
        </table>
        <br>
        <hr>
        <center><h1>Performance Report</h1></center>
        <hr>
        <br>
        <center><h2>Number of performances Report</h2></center>
        <center><table border="3px" class="table"></center>
            <tr>
                <td>Film Name</td>
                <td>Showing Number</td>
                <td>Number of performances</td>
                <td>Total seats left</td>
            </tr>
            
            <?php
                $sql = "SELECT Title,ShowingNo, count(*) as 'No of performances', sum(SeatsLeft) as 'Total seats left'
                From performance natural join showing natural join film
                group by ShowingNo;";
                $result = mysqli_query($conn,$sql);
                $resultCheck = mysqli_num_rows($result);
            
                if ($resultCheck > 0){
                    while($row = mysqli_fetch_assoc($result)){
                        echo '<tr>';
                        echo '<td>'.$row['Title'].'</td>';
                        echo '<td>'.$row['ShowingNo'].'</td>';
                        echo '<td>'.$row['No of performances'].'</td>';
                        echo '<td>'.$row['Total seats left'].'</td>';
                        echo '</tr>';
                    }
                }
            ?>
            
        </table>

    </div>
        

    </body>
</html>