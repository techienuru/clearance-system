<?php
class general
{
    public $connect;
    public $user_id;

    public $student_fullname;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function collectUserID()
    {
        if (isset($_SESSION["student_id"])) {
            $this->user_id = $_SESSION["student_id"];
        } else {
            header("location:../index.php");
        }
    }

    public function selectStudentDetails()
    {
        $sql = $this->connect->query("SELECT * FROM `student` INNER JOIN `department` ON student.department_id = department.department_id WHERE student_id = $this->user_id");
        $result = $sql->fetch_assoc();
        $this->student_fullname = $result["student_fullname"];
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
class dashboard extends general {}
class clearance_form extends general
{
    public $requirement_id;
    public $document;
    public $file_name;

    public function selectRequirements()
    {
        $role_id = $_GET["role_id"];

        $sql = $this->connect->query("SELECT * FROM `requirement` INNER JOIN `role` ON requirement.role_id = role.role_id WHERE requirement.role_id = $role_id");
        return $sql;
    }

    public function collectFormInputs()
    {
        $this->requirement_id = $this->validateInput($_POST["requirement_id"]);
        $this->document = $_FILES["document"];
    }

    public function imageProcessing()
    {
        $this->file_name = $this->document["name"];
        $file_name = $this->document["name"];
        $file_size = $this->document["size"];
        $file_tmp_name = $this->document["tmp_name"];

        $pathinfo_array = pathinfo($file_name, PATHINFO_ALL);
        $file_extension = strtolower($pathinfo_array["extension"]);

        $target_dir = "../Clearance Documents/";
        $target_dir .= $file_name;

        if (file_exists($target_dir) || $file_size > 1000000 || !in_array($file_extension, ["pdf", "jpg", "png", "jpeg"])) {

            if (file_exists($target_dir)) {
                $this->errorMessage("Image already exist");
                return false;
            }

            if ($file_size > 1000000) {
                $this->errorMessage("File is > 1MB");
                return false;
            }

            if (!in_array($file_extension, ["pdf", "jpg", "png", "jpeg"])) {
                $this->errorMessage("Only pdf, jpg, png & jpeg formats are allowed");
                return false;
            }
        } else {

            if (move_uploaded_file($file_tmp_name, $target_dir)) {
                $this->document = $target_dir;
                return true;
            }
        }
    }

    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `document` (requirement_id,student_id,file_name) VALUES ($this->requirement_id,$this->user_id,'$this->file_name')");

        if ($sql) {
            $this->displaySuccessMessage("clearance_form.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }
}
