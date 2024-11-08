<?php
class cRegister {
    private $conn;
    public $error;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        $this->error = '';
    }

    public function register($fname, $lname, $username, $password, $confirmPassword) {
        $fname = mysqli_real_escape_string($this->conn, $fname);
        $lname = mysqli_real_escape_string($this->conn, $lname);
        $username = mysqli_real_escape_string($this->conn, $username);
        $pass = md5($password);
        $cpass = md5($confirmPassword);
        $profile = "member";

        // Check if username already exists
        $select = "SELECT * FROM member WHERE username = '$username'";
        $result = mysqli_query($this->conn, $select);

        if(mysqli_num_rows($result) > 0) {
            $this->error = 'User Already Exist!';
        } elseif($pass != $cpass) {
            $this->error = 'Password Not Matched!';
        } else {
            $insert = "INSERT INTO member (fname, lname, username, password, profile) 
                       VALUES ('$fname', '$lname', '$username', '$pass', '$profile')";
            if (mysqli_query($this->conn, $insert)) {
                $_SESSION['success'] = 'Account created successfully! Please login.';
                header('Location: login.php');
                exit();
            } else {
                $this->error = 'Error creating account. Please try again.';
            }
        }
    }
}
?>
