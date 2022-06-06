<?php

include("../../includes/dbmethods.php");


function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['examid']) and isset($_POST['courseid'])) {
    $examid = test_input($_POST['examid']);
    $courseid = test_input($_POST['courseid']);
    $practicalMarks = $_POST['id'];
    $exam = DB::queryFirstRow("SELECT SUM(totalMarks+practicalMarks) as total, passingPercent, resultDeclared FROM exams WHERE id=%s", $examid);
    if (!$exam['resultDeclared']) {
        foreach ($practicalMarks as $id => $marks) {
            // $id = Student id
            //$marks = Practical Marks
            $exam_report = DB::queryFirstRow("SELECT marksObtain FROM exam_report WHERE examId=%s AND studentId=%s AND attendance=1 ", $examid, $id);
            $obtained_marks = $marks + $exam_report['marksObtain'];
            $percentage = ($obtained_marks * 100) / $exam['total'];
            $result = ($percentage >= $exam['passingPercent']) ? 'Pass' : 'Fail';

            DB::update(
                "exam_report",
                [
                    'practicalMarksObtain' => $marks,
                    'percentObtain' => $percentage,
                    'result' => $result
                ],
                "examId=%s AND studentId=%s",
                $examid,
                $id
            );
            DB::disconnect();
        }
        print_r($_POST);
        DB::update('exams', [
            'resultDeclared' => true
        ], 'id=%s', $examid);
    }
}
