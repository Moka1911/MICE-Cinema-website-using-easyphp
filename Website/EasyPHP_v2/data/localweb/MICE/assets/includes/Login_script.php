<?php
    if (isset($_POST['submit'])){
        require './Connection.inc.php';

        $Username = $_POST['Username'];
        $Password = $_POST['Password'];

        if(empty($Username) || empty($Password)){
            header("Location: application/views/LoginPage.php?error=emptyfields");
            exit();
        }
        else{
            $sql = "Select * From member where MUsername =?;";
            $statment = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($statment,$sql)){
                header("Location: application/views/LoginPage.php?error=sqlerror");
                exit();
            }
            else{

                mysqli_stmt_bind_param($statment,"s",$Username);
                mysqli_stmt_execute($statment);
                $result = mysqli_stmt_get_result($statment);
                if ($row = mysqli_fetch_assoc($result)) {
                    $hash = password_hash($row['MPassword'],PASSWORD_DEFAULT);
                    $password_check = password_verify($Password,$hash);
                    if ($password_check == true){
                        session_start();
                        $_SESSION['UserID'] = $row['MemberID'];
                        $_SESSION['Username'] = $row['MUsername'];
                        header("Location: application/views/homepage.php?login=Success");
                        exit();
                    }
                    elseif($password_check == false){
                        header("Location: application/views/LoginPage.php?error=wrongpassword");
                        exit();
                    }
                    else{
                        header("Location: application/views/LoginPage.php?error=wrongpassword");
                        exit();
                    }
                }
                else{
                    $sql = "Select * From staff where ManagerUsername =?;";
                    $statment = mysqli_stmt_init($conn);
                    if (!mysqli_stmt_prepare($statment,$sql)){
                        header("Location: application/views/LoginPage.php?error=sqlerror");
                        exit();
                    }
                    else{
        
                        mysqli_stmt_bind_param($statment,"s",$Username);
                        mysqli_stmt_execute($statment);
                        $result = mysqli_stmt_get_result($statment);
                        if ($row = mysqli_fetch_assoc($result)) {
                            $hash = password_hash($row['ManagerPassword'],PASSWORD_DEFAULT);
                            $password_check = password_verify($Password,$hash);
                            if ($password_check == true){
                                session_start();
                                $_SESSION['UserID'] = $row['EmployeeNo'];
                                $_SESSION['Username'] = $row['ManagerUsername'];
                                header("Location: application/views/homepage.php?login=Success");
                                exit();
                            }
                            elseif($password_check == false){
                                header("Location: application/views/LoginPage.php?error=wrongpassword");
                                exit();
                            }
                            else{
                                header("Location: application/views/LoginPage.php?error=wrongpassword");
                                exit();
                            }
                        }
                        else{
                            
        
                            header("Location: application/views/LoginPage.php?error=nomatchingusers");
                            exit();
                        }
                    }
                }
            }
        }

    }
    else{
        
        header("Location: application/views/LoginPage.php?");
        exit();
    }
