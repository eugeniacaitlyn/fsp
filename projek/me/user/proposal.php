<?php
    session_start();
    @include '../database.php';

    $successMessage = "";

    if(isset($_GET['idmember'])){
        $idmember = $_GET['idmember'];
    } else {
        $idmember = 'Unknown';
    }

    $teamsQuery = "SELECT idteam, name FROM team";
    $teamsResult = mysqli_query($conn, $teamsQuery);

    if(isset($_POST['submit'])){
        $idteam = $_POST['idteam'];
        $description = mysqli_real_escape_string($conn, $_POST['reason']);
        
        $insertQuery = "INSERT INTO join_proposal (idmember, idteam, description) VALUES ('$idmember', '$idteam', '$description')";
        $insertResult = mysqli_query($conn, $insertQuery);
        
        if($insertResult){
            $successMessage = "Join proposal submitted successfully!";
        } else {
            $successMessage = "Failed to submit join proposal. Please try again.";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join a team</title>
    <link rel="stylesheet" href="../css/loginregist.css">
    <link rel='stylesheet' href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css'>
    <style>
        .wrapper .pertanyaan{
            margin-top: 12px;
            margin-bottom: 50px;
        }
        .wrapper .select-box{
            position: relative;
            width : 100%;
            height : 48px;
            width: 100%;
            height: 100%;
            background-color: transparent;
            border: none;
            outline: none;
            border: 1px solid rgb(255, 255, 255);
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            padding: 20px;
            margin: 8px 0px
        }
        .select-box select{
            height: 100%;
            width: 100%;
            outline: none;
            border: none;
            color: #D4D4D4;
            font-size: 16px;
            background: transparent;
        }
        .input-box input {
            width: 100%;
            height: 100%;
            background : transparent;
            border: none;
            outline: none;
            border: 1px solid rgb(255, 255, 255);
            border-radius: 8px;
            font-size: 16px;
            color: #fff;
            padding: 20px;
            margin: 8px 0px
        }
    </style>
    <script>
        function showConfirmation(message) {
            if (message !== "") {
                alert(message);
                window.location.href = 'home.php';
            }
        }
    </script>
</head>
<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Join a Team</h1>
                <?php
                    if($successMessage !== ""){
                        echo "<script>showConfirmation('$successMessage');</script>";
                    }
                ?>
            <div class="pertanyaan">
                <label class="label">Select a Team:</label>
                <div class="select-box">
                    <select name="idteam" id="team" required>
                        <option value="" disabled selected>Team's name</option>
                        <?php
                            if(mysqli_num_rows($teamsResult) > 0){
                                while($team = mysqli_fetch_assoc($teamsResult)){
                                    echo "<option value='{$team['idteam']}'>{$team['name']}</option>";
                                }
                            } else {
                                echo "<option value=''>No teams available</option>";
                            }
                        ?>
                    </select>
                </div>
                <label class="label" for="team">Reason to join:</label><br>
                <div class="input-box">
                    <input type="text-area" name="reason" required placeholder="My reason is">
                </div>
            </div>

            <div class="button">
                <button type="submit" name="submit" value="submit" class="btn-submit">Submit</button>
                <button type="back" class="btn-back" onclick= "window.location.href='home.php'">Back</button>
            </div>            
        </form>
    </div>
</body>
</html>
