<?php
class cLogin {
    private $conn;
    public $error;

    public function __construct($dbConnection) {
        $this->conn = $dbConnection;
        $this->error = '';
    }

    public function login($username, $password) {
        $username = mysqli_real_escape_string($this->conn, $username);
        $password = md5($password);

        $query = "SELECT * FROM member WHERE username = '$username' && password = '$password'";
        $result = mysqli_query($this->conn, $query);

        if(mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);

            if($row['profile'] == 'admin') {
                $_SESSION['username'] = $row['username'];
                header('Location: admin/home.php');
                exit();
            } elseif($row['profile'] == 'member') {
                $_SESSION['username'] = $row['username'];
                header('Location: user/home.php');
                exit();
            }
        } else {
            $this->error = 'Username or Password is incorrect. Please try again.';
        }
    }
}
?>
