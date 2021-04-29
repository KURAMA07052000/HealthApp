<!DOCTYPE html>
<html lang="en">
    <head>
        <?php session_start();
        if(!$_SESSION['user']) {
            header("location: index.php");
        }
        $user = $_SESSION['user']; ?>
        <link href="default.css" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            #addhata {
                width: 100%;
                padding: 50px 0;
                text-align: left;
                background-color: #ccffff;
                margin-top: 20px;
            }
            #addexcercise {
                width: 100%;
                padding: 50px 0;
                text-align: left;
                background-color: #ccffff;
                margin-top: 20px;
            }
            #addreminder {
                width: 100%;
                padding: 50px 0;
                text-align: left;
                background-color: #ccffff;
                margin-top: 20px;
            }
        </style>
        <title>A3 Health - Manage Personal Data</title>
    </head>
    <body>
        <?php include 'header.php'?>
        <p>Manage Your Personal Health Data</p>
        
        <button onclick="toggledisphdata()">Log Physiological Data</button>
        <button onclick="toggleexcercise()">Log Excercise Data</button>
        <button onclick="togglereminder()">Log Reminder/Appointment</button>
        

        <div id="addhdata">
            Please enter your Physiological Data Below <br>
            <form action="health.php" name="physio" method="POST">
                Heartbeat/Pulse rate: <input type="text" name="heartrate" > <br>
                Body Temperature: <input type="text" name="bodtemp"> <br>
                Blood Pressure: <input type="text" name="blpressure"> <br>
                Blood Oxygen: <input type="text" name="bloxygen" > <br>
                Breathing/Respiration Rate: <input type="text" name="breathrate" > <br>
                ECG Details: <input type="text" name="ecgdet" > <br>
                <input type="submit" name="physio" value="Save Physiological Data">
            </form>
        </div>

        <div id="addexcercise">
        Please enter your Exercise Details Below
            <form action="health.php" name="exercise" method="POST">
                Exercise Name: <input type="text" name="ename" > <br>
                Exercise Duration: <input type="text" name="etime"> <br>
                Exercise Notes: <input type="text" name="enotes"> <br>
                <input type="submit" name="exercise" value="Save Excercise Details">
            </form>
        </div>

        <div id="addreminder">
        Please enter the date of your reminder/appointment followed by the details

            <form action="health.php" name="appointment" method="POST">
                Date of Reminder/Appointment: <input type="text" name="reminderdate" > <br>
                Reminder Details: <input type="text" name="reminderdetails"> <br>
                <input type="submit" name="appointment" value="Save Reminder/Appointment">
            </form>
        </div>

        <script>
            function toggledisphdata() {
                var x = document.getElementById("addhdata");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
            function toggleexcercise() {
                var x = document.getElementById("addexcercise");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
            function togglereminder() {
                var x = document.getElementById("addreminder");
                if (x.style.display === "none") {
                    x.style.display = "block";
                } else {
                    x.style.display = "none";
                }
            }
        </script>
    </body>
</html>

<?php
    $server = "localhost";
    $username = "root" ;
    $password = "";
    $dbname = "health_app";

    $conn = new mysqli($server , $username , $password , $dbname);

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $timestamp = date('Y-m-d H:i:s');
        if(isset($_POST['physio'])){
            if(!empty($_POST['bodtemp']) && !empty($_POST['heartrate']) && !empty($_POST['blpressure']) && !empty($_POST['bloxygen']) && !empty($_POST['breathrate']) && !empty($_POST['ecgdet'])){
                
                $heartrate = $_POST['heartrate'];
                $bodtemp = $_POST['bodtemp'];
                $blpressure = $_POST['blpressure'];
                $bloxygen = $_POST['bloxygen'];
                $breathrate = $_POST['breathrate'];
                $ecgdet = $_POST['ecgdet'];
                
                $query = "INSERT INTO health_data(user_id, timestamp, heartrate, bodtemp, blpressure, bloxygen, breathrate, ecgdet) VALUES ('$user', '$timestamp', '$heartrate', '$bodtemp', '$blpressure', '$bloxygen', '$breathrate', '$ecgdet')" ;
                
            } else {
                echo "all fields required";
            }
        } else if(isset($_POST['exercise'])){
            if(!empty($_POST['ename']) && !empty($_POST['etime']) && !empty($_POST['enotes'])){
                $ename = $_POST['ename'];
                $etime = $_POST['etime'];
                $enotes = $_POST['enotes'];

                $query = "INSERT INTO exercise_data(user_id, timestamp, ename, etime, enotes) VALUES ('$user', '$timestamp', '$ename', '$etime', '$enotes')";
            } else {
                echo "All fields required";
            }
        } else if(isset($_POST['appointment'])){
            if(!empty($_POST['reminderdate']) && !empty($_POST['reminderdetails'])){
                $reminderdate = $_POST['reminderdate'];
                $reminderdetails = $_POST['reminderdetails'];

                $query = "INSERT INTO reminders(user_id, timestamp, reminderdate, reminderdetails) VALUES ('$user', '$timestamp', '$reminderdate', '$reminderdetails')";
            } else {
                echo "All fields required";
            }
        }
        mysqli_query($conn, $query);
    }
?>