<?php

// Check if our ABSPATH is defined
defined("API_ABSPATH") or die("Don't mess!");

/**
 * Lists all courses assigned to the user.
 */
function getAssignedCourses(){

    global $connection;

    global $response;

    $stmt = $connection->stmt_init();

    $stmt->prepare("SELECT classid FROM skymake_class_assigned WHERE username=?");

    $stmt->bind_param("s",$_GET["username"]);

    $stmt->execute();

    $result = $stmt->get_result();

    $classid = "";

    if($result->num_rows == 1){

        $row = $result->fetch_assoc();

        $classid = $row["classid"];

    }

    $response["status"]["code"] = "200";

    $coursesArray = array();

    $stmt2 = $connection->stmt_init();

    $stmt2->prepare("SELECT lessonid,lesson,teacher,time,bgurl FROM skymake_assignments WHERE classid=? ORDER BY time ASC");

    $stmt2->bind_param("s",$classid);

    $stmt2->execute();

    $result2 = $stmt2->get_result();

    if($result2->num_rows > 0){

        while($row = $result2->fetch_assoc()) {

            $course["name"] = $row["lesson"];
            $course["teacher"] = $row["teacher"];
            $course["time"] = $row["time"];
            $course["image"] = $row["bgurl"];
            $course["contents"] = array();

            $stmt3 = $connection->stmt_init();

            $stmt3->prepare("SELECT * FROM skymake_lessoncontent WHERE lessonid=?");

            $stmt3->bind_param("s",$row["lessonid"]);

            $stmt3->execute();

            $result3 = $stmt3->get_result();

            if($result3->num_rows > 0){

                while($row1 = $result3->fetch_assoc()){

                    $lessonContent["id"] = $row1["content-id"];
                    $lessonContent["type"] = $row1["content-type"];
                    $lessonContent["url"] = $row1["content-link"];

                    array_push($course["contents"], $lessonContent);
                }

            }

            array_push($coursesArray,$course);

        }

    }

    $response["result"]["coursesArray"] = $coursesArray;

}