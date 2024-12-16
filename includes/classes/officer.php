<?php
class general
{
    public $connect;
    public $user_id;

    public $role_id;
    public $role_name;
    public $fullname;

    public function __construct($connect)
    {
        $this->connect = $connect;
    }

    public function collectUserID()
    {
        if (isset($_SESSION["admin_id"])) {
            $this->user_id = $_SESSION["admin_id"];
        } else {
            header("location:../index.php");
        }
    }

    public function selectOfficerDetails()
    {
        $sql = $this->connect->query("SELECT * FROM `admin` INNER JOIN `role` ON admin.role_id = role.role_id WHERE admin_id = $this->user_id");
        $result = $sql->fetch_assoc();
        $this->role_id = $result["role_id"];
        $this->role_name = $result["role_name"];
        $this->fullname = $result["fullname"];
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
class add_requirements extends general
{
    public $requirement_title;
    public $requirement_description;

    public function collectFormInputs()
    {
        $this->requirement_title = $this->validateInput($_POST["requirement_title"]);
        $this->requirement_description = $this->validateInput($_POST["requirement_description"]);
    }

    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `requirement` (requirement_title,requirement_description,admin_id,role_id) VALUES ('$this->requirement_title','$this->requirement_description',$this->user_id,$this->role_id)");

        if ($sql) {
            $this->displaySuccessMessage("add_requirements.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }

    public function selectRequirements()
    {
        $sql = $this->connect->query("SELECT * FROM `requirement` WHERE requirement.admin_id = $this->user_id AND requirement.role_id = $this->role_id");
        return $sql;
    }

    public function deleteRequirement()
    {
        $requirement_id = $this->validateInput($_POST["requirement_id"]);

        $sql = $this->connect->query("DELETE FROM `requirement` WHERE requirement_id = '$requirement_id'");

        if ($sql) {
            $this->displaySuccessMessage("add_requirements.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }
}
class pending_clearance extends general
{
    public function selectSubmittedDocumentsList()
    {
        $sql = $this->connect->query("SELECT DISTINCT(document.student_id) AS student_id,matric_no,department_id,student_fullname FROM `document` INNER JOIN `requirement` ON document.requirement_id = requirement.requirement_id INNER JOIN `student` ON document.student_id = student.student_id WHERE requirement.admin_id =$this->role_id");
        return $sql;
    }


    public function fetchDepartmentName($department_id)
    {
        $sql = $this->connect->query("SELECT * FROM `department` WHERE department_id = $department_id");
        $result = $sql->fetch_assoc();
        return $result["department_name"];
    }
}


class submitted_document extends general
{
    public function checkIfAuthorised()
    {
        if (!isset($_GET["student_id"])) {
            header("location:./pending_clearance.php");
        }
    }

    public function fetchPassesStudentName($student_id)
    {
        $sql = $this->connect->query("SELECT * FROM `student` WHERE student_id = $student_id");
        $result = $sql->fetch_assoc();
        return $result["student_fullname"];
    }

    public function selectStudentDocuments($student_id)
    {
        $sql = $this->connect->query("SELECT * FROM `document` INNER JOIN `requirement` ON document.requirement_id = requirement.requirement_id INNER JOIN `student` ON document.student_id = student.student_id WHERE document.student_id = $student_id AND requirement.admin_id =$this->role_id");
        return $sql;
    }
}
