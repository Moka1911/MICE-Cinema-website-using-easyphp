<?php
  session_start();
  include_once 'assets/includes/Connection.inc.php';
  $FilmID = '';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manager page</title>
    <link href="<?php echo base_url().'assets\grocery_crud\css\ui\simple\booking.css'?>" rel="stylesheet">
</head>

<body>
<?php
    $Title = $_GET['title'];
    $sql = "Select * From film Where Title = '$Title';" ;
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $Released = $row['Released'];
            $Director = $row['Director'];
            $Classification = $row['Classification'];
            $Duration = $row['Duration'];
            $Description = $row['Description'];
            $ImagePath = $row['ImagePath'];
            $FilmID = $row['FilmID'];
        }
    }
?>
<?php
    $Title = $_GET['title'];
    $sql = "Select * From film Where Title = '$Title';" ;
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $Released = $row['Released'];
            $Director = $row['Director'];
            $Classification = $row['Classification'];
            $Duration = $row['Duration'];
            $Description = $row['Description'];
            $ImagePath = $row['ImagePath'];
            $FilmID = $row['FilmID'];
        }
    }
?>
    
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
            echo '<a id="SignIN" class="Log" href="';
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
                echo '<a id="SignIN" class="Log" href="';
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
           echo ' <a class="Log" id="SignIN" href="';
           echo site_url('Main/login_page');
           echo '">Sign in</a>
          </div>
        </div>
    </nav>';
    }
?>


<div class="container" style="display:inline-block;vertical-align:top;">
        <img  class="image" src="<?php echo base_url().$ImagePath?>" alt="<?php echo $Title?>">
    </div>

    <div class="container" id="widder" style="display:inline-block;">
        <h2><?php echo $Title?></h2>
        <h3><br>SYNOPSIS</h3>
        <h3><?php echo $Description?></h3>
        <h3><br>DIRECTOR</h3>
        <h3><?php echo $Director?></h3>
    </div>
    
    <div >
        
    <div class="container2">
    <form action="<?php echo site_url('Main/Add_booking')."?FilmID=$FilmID"?>" name="form" id="form" method="POST">
        <div class="select-cinema">
        <h3 > Show me times for</h3>
            <label>
                <select form="form" id="Cinema" onchange="validate(); trying();" name="Cinema" type='text'>
                    <option selected value="Select Cinema">Select Cinema</option>
                    <?php
                        $sql = "SELECT CName,ScreenNo,ShowingNo,FilmID
                        From cinema natural join Screen natural join Showing natural join film
                        where FilmID = $FilmID";
                        $result = mysqli_query($conn,$sql);
                        $resultCheck = mysqli_num_rows($result);
                    
                        if ($resultCheck > 0){
                            while($row = mysqli_fetch_assoc($result)){
                                echo '<option value=';
                                echo $row['CName'];
                                echo '>'.$row['CName'].'</option>.';
                            }
                        }
                    ?>
                </select>
            </label>
        </div>
        <?php
            $sql2 = "SELECT CName,Date,Time
            From cinema natural join Screen natural join Showing natural join film natural join performance
            where FilmID = $FilmID
            Group by CName,Date,Time;";
            $result1 = mysqli_query($conn,$sql2);
            $resultCheck1 = mysqli_num_rows($result1);

            $allarray=array();
            $existarray=array();
            $Intu= array();
            $Phoenix=array();
            $Rialto=array();
            $Intimate=array();

            $indexE=0;
            $indexall=0;
            $indexI=0;
            $indexP=0;
            $indexR=0;
            $indexIN=0;

            if ($resultCheck1 > 0){
                while($row = mysqli_fetch_assoc($result1)){
                    $Cinema_name = $row['CName'];
                    $Date = $row['Date'];
                    $allarray[$indexall] = $Date;
                    $indexall++;
                    if($Cinema_name == 'Intu'){
                        $Intu[$indexI]= $Date;
                        $indexI++;
                        $existarray[$indexE] = $Date;
                        $indexE++;
                    }
                    else if($Cinema_name == 'Phoenix'){
                        $Phoenix[$indexP]= $Date;
                        $indexP++;
                        $existarray[$indexE] = $Date;
                        $indexE++;
                    }
                    else if($Cinema_name == 'Rialto'){
                        $Rialto[$indexR]= $Date;
                        $indexR++;
                        $existarray[$indexE] = $Date;
                        $indexE++;
                    }
                    else if($Cinema_name == 'Intimate'){
                        $Intimate[$indexIN]= $Date;
                        $indexIN++;
                        $existarray[$indexE] = $Date;
                        $indexE++;
                    }
                }
            }

                    echo '
                <script>
                    function trying()
                    {
                        var cinema = document.getElementById('."'Cinema'".').value;
                        document.getElementById('."'Date'".').style.display = '."'none'".';
                        document.getElementById('."'Date'".').selectedIndex = 0;
                        document.getElementById('."'Date'".').style.display = '."'block'".';
                        if(cinema == "Intu"){
                            var Dates = [';
                            for ($x=0; $x < count($Intu) ; $x++) { 
                                echo "'".$Intu[$x]."',";
                            }
                            echo "' "."'";
                            echo '];
                            let index = 0;
                            let arrayLength = Dates.length - 1;
                            while(index < arrayLength ) {
                                document.getElementById(Dates[index]).style.display = "block";
                                index++;
                            }
                            var BDates =[';
                            $big_array = array_merge($Phoenix,$Rialto,$Intimate);
                            for ($w=0; $w < count($big_array) ; $w++) { 
                                echo "'".$big_array[$w]."',";
                            }
                            echo "' "."'";
                            echo ']
                            let index1 = 0;
                            let arrayLength1 =BDates.length - 1;
                            while(index1 < arrayLength1 ) {
                                document.getElementById(BDates[index1]).style.display = '."'none'".';
                                index1++;
                            }
        
                        }
                        else if(cinema == "Phoenix"){
                            var Dates = [';
                            
                            if(count($Phoenix) == 0){
                                for ($x=0; $x < count($Phoenix) ; $x++) { 
                                    echo "'".$Phoenix[$x]."',";
                                }
                            }
                            echo "' "."'";
                            echo '];
                            let index = 0;
                            let arrayLength = Dates.length - 1;
                            while(index < arrayLength ) {
                                document.getElementById(Dates[index]).style.display = "block";
                                index++;
                            }
                            var BDates =[';
                            $big_array = array_merge($Intu,$Rialto,$Intimate);
                            for ($w=0; $w < count($big_array) ; $w++) { 
                                echo "'".$big_array[$w]."',";
                            }
                            echo "' "."'";
                            echo ']
                            let index1 = 0;
                            let arrayLength1 =BDates.length - 1;
                            while(index1 < arrayLength1 ) {
                                document.getElementById(BDates[index1]).style.display = "none";
                                index1++;
                            }
                        }
                        else if(cinema == "Rialto"){
                            var Dates = [';
                            for ($x=0; $x < count($Rialto) ; $x++) { 
                                echo "'".$Rialto[$x]."',";
                            }
                            echo "' "."'";
                            echo '];
                            let index = 0;
                            let arrayLength = Dates.length - 1;
                            while(index < arrayLength ) {
                                document.getElementById(Dates[index]).style.display = "block";
                                index++;
                            }
                            var BDates =[';
                            $big_array = array_merge($Intu,$Phoenix,$Intimate);
                            for ($w=0; $w < count($big_array) ; $w++) { 
                                echo "'".$big_array[$w]."',";
                            }
                            echo "' "."'";
                            echo ']
                            let index1 = 0;
                            let arrayLength1 =BDates.length - 1;
                            while(index1 < arrayLength1 ) {
                                document.getElementById(BDates[index1]).style.display = "none";
                                index1++;
                            }
                        }
                        else if(cinema == "Intimate"){
                            var Dates = [';
                            for ($x=0; $x < count($Intimate) ; $x++) { 
                                echo "'".$Intimate[$x]."',";
                            }
                            echo "' "."'";
                            echo '];
                            let index = 0;
                            let arrayLength = Dates.length - 1;
                            while(index < arrayLength ) {
                                document.getElementById(Dates[index]).style.display = "block";
                                index++;
                            }
                            var BDates =[';
                            $big_array = array_merge($Intu,$Rialto,$Phoenix);
                            for ($w=0; $w < count($big_array) ; $w++) { 
                                echo "'".$big_array[$w]."',";
                            }
                            echo "' "."'";
                            echo ']
                            let index1 = 0;
                            let arrayLength1 =BDates.length - 1;
                            while(index1 < arrayLength1 ) {
                                document.getElementById(BDates[index1]).style.display = "none";
                                index1++;
                            }
                        }
                        else{
                            var Dates = [';
                            $wantedarray = array_diff($allarray,$existarray);
                            for ($x=0; $x < count($wantedarray) ; $x++) { 
                                echo "'".$wantedarray[$x]."',";
                            }
                            echo "' "."'";
                            echo '];
                            let index = 0;
                            let arrayLength = Dates.length - 1;
                            while(index < arrayLength ) {
                                document.getElementById(Dates[index]).style.display = "block";
                                index++;
                            }
                            var BDates =[';
                            for ($x=0; $x < count($existarray) ; $x++) { 
                                echo "'".$existarray[$x]."',";
                            }
                            echo "' "."'";
                            echo ']
                            let index1 = 0;
                            let arrayLength1 =BDates.length - 1;
                            while(index1 < arrayLength1 ) {
                                document.getElementById(BDates[index1]).style.display = "none";
                                index1++;
                            }
                        }
                    }
                </script>
                ';


        ?>

        <div class="select-seats">
        <h3 > Number of Seats</h3>

            <label>
            
                <select id="Seat" form="form" onchange="validate()" name="Seat" type='text'>
                    <option value="Select Seat">Select Seat</option>
                    <?php
                         $sql = "Select max(SeatsLeft) as 'Seats_left' From performance natural join showing WHERE FilmID = $FilmID;";
                         $result = mysqli_query($conn,$sql);
                          $resultCheck = mysqli_num_rows($result);
                                            
                          if ($resultCheck > 0){
                              while($row = mysqli_fetch_assoc($result)){
                                $Seats_left = $row['Seats_left'];
                           }
                         }
                        for ($i=1; $i<=$Seats_left; $i++)
                        {

                            ?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                            <?php
                        }
                    ?>
                </select>
            </label>
            
        </div>

        <div class="text2">
            
        </div>

        <div class="select-date1">
        <h3 > Date Availability</h3>    
            <label>
            
                <select id="Date" form="form" onchange="validate()" name="Date" type='text'>
                    <option value="Select Date" selected>Select Date</option>
                    <?php
                         $sql = "Select Date from performance natural join showing where FilmID = $FilmID group by Date;";
                         $result = mysqli_query($conn,$sql);
                          $resultCheck = mysqli_num_rows($result);
                                            
                          if ($resultCheck > 0){
                              while($row = mysqli_fetch_assoc($result)){
                                $Dates = $row['Date'];
                                echo '<option style="display: none" id="'.$Dates.'" value="';
                                echo $Dates;
                                echo '">';
                                echo $Dates;
                                echo '</option>';
                           }
                         }

                    ?>
                </select>
            </label>
            
        </div>


        

    </div>
  

  
    <br>
    
    <div class="showings" id="squares" style="visibility: hidden;">
    <?php
        $sql = "SELECT CName,ScreenNo,Time,FilmID
        From cinema natural join Screen natural join Showing natural join film natural join performance
        where FilmID = $FilmID
        Group by CName,ScreenNo,Time,FilmID;";
        $result = mysqli_query($conn,$sql);
        $resultCheck = mysqli_num_rows($result);
                                            
        if ($resultCheck > 0){
            while($row = mysqli_fetch_assoc($result)){
                $CName = $row['CName'];
                $ScreenNo = $row['ScreenNo'];
                $Time = $row['Time'];

                echo '
            <div class="square" id="'.$CName.'">
                <div class="content" >
                    <button form="form" type="submit" name="submit1">
                        <h2>Screen'.$ScreenNo.'</h2>
                        <h2>'.$Time.'</h2>
                        <h2>Cinema '.$CName.'<h2>
                    </button>
                </div>
            </div>
            ';
                
            }
        }
    ?>
    </div>
    </form>
    <br>
    <br>
    <br>
    <hr>
    <center><h2>Note: you cant progress without being signed in</h2></center>
    <hr>

    
    <?php 
    $sql = "SELECT CName,ScreenNo,Time,FilmID
    From cinema natural join Screen natural join Showing natural join film natural join performance
    where FilmID = $FilmID
    Group by CName,ScreenNo,Time,FilmID;";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);
    $array[] = array();
    $i =0;        
    if ($resultCheck > 0){
        while($row = mysqli_fetch_assoc($result)){
            $array[$i] = $row['CName'];
            $i++;

        }
    }



    
    
    echo'
    <script>
            function validate()
            {
                var selected_value1 = document.getElementById('."'Seat'".').value;
                var selected_value2 = document.getElementById('."'Cinema'".').value;
                var selected_value3 = document.getElementById('."'Date'".').value;
                var sign_in = document.getElementById('."'SignIN'".').text;
                if (selected_value1 != "Select Seat" && selected_value2 != "Select Cinema" && selected_value3 != "Select Date" && sign_in != "Sign in")
                {
                    document.getElementById('."'squares'".').style.visibility = "visible";

                    const cinemas = [';
                    for ($x=0; $x < count($array) ; $x++) { 
                        echo "'".$array[$x]."',";
                    }
                    echo "' "."'";
                    echo '];
                    let i = 0;
                    let arrayLength = cinemas.length;
                    while(i < arrayLength ) {
                        let val = cinemas[i];
                        if (val != selected_value2){
                            document.getElementById(val).style.visibility = "hidden";
                        }
                        else{
                            document.getElementById(val).style.visibility = "visible";
                        }
                        i++;
                    }

                }
                else if (selected_value1 == "Select Seat" || selected_value2 == "Select Cinema" || selected_value3 == "Select Date")
                {
                    document.getElementById('."'squares'".').style.visibility = "hidden";

                }
                

            }

    </script>
    '?>



</body>
</html>