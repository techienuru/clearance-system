<?php
session_start();
include_once "../includes/connect.php";
include_once "../includes/classes/officer.php";

$object = new submitted_document($connect);


if (!isset($_GET["document_id"])) {
    header("location:./pending_clearance.php");
} else {
    $document_id = $_GET["document_id"];
    $status = $_GET["status"];
    switch ($status) {
        case 'approve':
            $query = "UPDATE `document` SET status = 'approved' WHERE document_id=$document_id";
            break;

        case 'decline':
            $query = "UPDATE `document` SET status = 'declined' WHERE document_id=$document_id";
            break;
    }
    $sql = $object->connect->query("$query");
    if ($sql) {
        $object->displaySuccessMessage("submitted_document.php");
    } else {
        $object->errorMessage($object->connect->error);
    }
}
