<?php
class general
{
    public $connect;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    protected function validateInput($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    public function displaySuccessMessage($href)
    {
        echo "
            <script>
                window.alert('Success!');
                window.location.href='" . $href . "';
            </script>
        ";
        die();
    }


    public function errorMessage($message)
    {
        echo '
            <script>
                window.alert("' . $message . '");
            </script>
        ';
    }
}


class login extends general
{
    public $email_matric;
    public $password;
    public $login_err;
    public $whoIsPassed;

    public function collectInputs()
    {
        $this->email_matric = $this->validateInput($_POST["email_matric_no"]);
        $this->password = $this->validateInput($_POST["password"]);
    }

    public function authorizeFromAdmin()
    {
        $select_from_admin = $this->connect->query("SELECT * FROM `admin` WHERE email = '$this->email_matric' AND password = '$this->password'");
        $result = $select_from_admin->fetch_assoc() ?? null;
        if ($select_from_admin->num_rows <= 0) {
            $this->login_err = "Invalid Credentials!";
        } else {
            $_SESSION["admin_id"] = $result["admin_id"];
            $this->whoIsPassed = ($result["role_id"] == 1) ? "admin" : "officer";
            $this->redirection();
            return true;
        }
        return false;
    }

    public function authorizeFromStudent()
    {
        $select_from_student = $this->connect->query("SELECT * FROM `student` WHERE matric_no = '$this->email_matric' AND password = '$this->password'");
        $result = $select_from_student->fetch_assoc() ?? null;

        if ($select_from_student->num_rows <= 0) {
            $this->login_err = "Invalid Credentials!";
        } else {
            $this->login_err = null;
            $_SESSION["student_id"] = $result["student_id"];
            $this->whoIsPassed = "student";
            $this->redirection();
        }
    }

    public function redirection()
    {
        switch ($this->whoIsPassed) {
            case 'admin':
                header("location:./Admin/dashboard.php");
                break;

            case 'officer':
                header("location:./Officers/dashboard.php");
                break;

            case 'student':
                header("location:./Student/dashboard.php");
                break;
        }
    }
}
