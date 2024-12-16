<?php
class general
{
    public $connect;
    public $user_id;

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
class manage_facult_department extends general
{
    public $form_input_one;
    public $form_input_two;


    public function selectFaculties()
    {
        $sql = $this->connect->query("SELECT * FROM `faculty`");
        return $sql;
    }

    public function selectDepartments()
    {
        $sql = $this->connect->query("SELECT * FROM `department` INNER JOIN `faculty` ON department.faculty_id = faculty.faculty_id");
        return $sql;
    }

    public function collectFormInputs($form_input_one_name)
    {
        $this->form_input_one = $this->validateInput($_POST["$form_input_one_name"]);
    }

    public function insertFacultyIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `faculty` (faculty_name) VALUES ('$this->form_input_one')");

        if ($sql) {
            $this->displaySuccessMessage("faculty_department.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }

    public function insertDepartmentIntoDB()
    {
        $this->form_input_two = $this->validateInput($_POST["faculty_id"]);

        $sql = $this->connect->query("INSERT INTO `department` (department_name,faculty_id) VALUES ('$this->form_input_one',$this->form_input_two)");

        if ($sql) {
            $this->displaySuccessMessage("faculty_department.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }

    public function deleteFaculty()
    {
        $faculty_id = $this->validateInput($_POST["faculty_id"]);

        $sql = $this->connect->query("DELETE FROM `faculty` WHERE faculty_id = '$faculty_id'");

        if ($sql) {
            $this->displaySuccessMessage("faculty_department.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }

    public function deleteDepartment()
    {
        $department_id = $this->validateInput($_POST["department_id"]);

        $sql = $this->connect->query("DELETE FROM `department` WHERE department_id = '$department_id'");

        if ($sql) {
            $this->displaySuccessMessage("faculty_department.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }
}

class manage_officers extends general
{
    public $role_id;
    public $officer_name;
    public $officer_email;
    public $officer_password;

    public function selectRoles()
    {
        $sql = $this->connect->query("SELECT * FROM `role`");
        return $sql;
    }
    public function collectFormInputs()
    {
        $this->role_id = $this->validateInput($_POST["role_id"]);
        $this->officer_name = $this->validateInput($_POST["officer_name"]);
        $this->officer_email = $this->validateInput($_POST["officer_email"]);
        $this->officer_password = $this->validateInput($_POST["officer_password"]);
    }

    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `admin` (fullname,email,password,role_id) VALUES ('$this->officer_name','$this->officer_email','$this->officer_password',$this->role_id)");

        if ($sql) {
            $this->displaySuccessMessage("manage_officers.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }

    public function selectOfficers()
    {
        $sql = $this->connect->query("SELECT * FROM `admin` INNER JOIN `role` ON admin.role_id = role.role_id");
        return $sql;
    }

    public function deleteOfficer()
    {
        $officer_id = $this->validateInput($_POST["officer_id"]);

        $sql = $this->connect->query("DELETE FROM `admin` WHERE admin_id = '$officer_id'");

        if ($sql) {
            $this->displaySuccessMessage("manage_officers.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }
}

class manage_students extends general
{
    public $matric_no;
    public $student_fullname;
    public $department_id;

    public function selectDepartments()
    {
        $sql = $this->connect->query("SELECT * FROM `department` INNER JOIN `faculty` ON department.faculty_id = faculty.faculty_id");
        return $sql;
    }

    public function selectStudents()
    {
        $sql = $this->connect->query("SELECT * FROM `student` INNER JOIN `department` ON student.department_id = department.department_id");
        return $sql;
    }

    public function fetchFacultyOfDepartment($faculty_id)
    {
        $sql = $this->connect->query("SELECT * FROM `faculty` WHERE faculty_id = $faculty_id");
        $result = $sql->fetch_assoc();
        return $result["faculty_name"];
    }

    public function collectFormInputs()
    {
        $this->matric_no = $this->validateInput($_POST["matric_no"]);
        $this->student_fullname = $this->validateInput($_POST["student_fullname"]);
        $this->department_id = $this->validateInput($_POST["department_id"]);
    }

    public function insertIntoDB()
    {
        $sql = $this->connect->query("INSERT INTO `student` (matric_no,student_fullname,department_id,password) VALUES ('$this->matric_no','$this->student_fullname',$this->department_id,'12345')");

        if ($sql) {
            $this->displaySuccessMessage("manage_students.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }

    public function selectOfficers()
    {
        $sql = $this->connect->query("SELECT * FROM `admin` INNER JOIN `role` ON admin.role_id = role.role_id");
        return $sql;
    }

    public function deleteStudent()
    {
        $student_id = $this->validateInput($_POST["student_id"]);

        $sql = $this->connect->query("DELETE FROM `student` WHERE student_id = '$student_id'");

        if ($sql) {
            $this->displaySuccessMessage("manage_students.php");
        } else {
            $this->errorMessage($this->connect->error);
        }
    }
}
