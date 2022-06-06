<?php include("../includes/dbmethods.php") ?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" or $_SERVER["REQUEST_METHOD"] == "GET")
    if (isset($_REQUEST['print']) && isset($_REQUEST['examid'])) {
        $eid = $_REQUEST['examid'];
        $exam = DB::queryFirstRow("SELECT examName, name as courseName,examDate,totalMarks,practicalMarks,resultDeclared 
                                FROM exams 
                                RIGHT JOIN courses
                                ON exams.course = courses.id
                                WHERE exams.id=%s", $eid);
        DB::disconnect();
        if ($exam['resultDeclared']) {
            $result_arr = DB::query("SELECT studentId,uname,marksObtain,practicalMarksObtain,percentObtain,result
                            FROM exam_report
                            RIGHT JOIN admissions
                            ON studentId = admissions.id
                            WHERE examId=%s ORDER BY percentObtain desc", $eid);

?>

        <style type="text/css">
            .tg {
                border-collapse: collapse;
                border-spacing: 0;
            }

            .tg td {
                border-color: black;
                border-style: solid;
                border-width: 1px;
                font-family: Arial, sans-serif;
                font-size: 14px;
                overflow: hidden;
                padding: 10px 5px;
                word-break: normal;
            }

            .tg th {
                border-color: black;
                border-style: solid;
                border-width: 1px;
                font-family: Arial, sans-serif;
                font-size: 14px;
                font-weight: normal;
                overflow: hidden;
                padding: 10px 5px;
                word-break: normal;
            }

            .tg .tg-c3ow {
                border-color: inherit;
                text-align: center;
                vertical-align: top
            }

            .tg .tg-p8sp {
                border-color: inherit;
                font-size: 20px;
                text-align: center;
                vertical-align: top
            }

            .tg .tg-fymr {
                border-color: inherit;
                font-weight: bold;
                text-align: left;
                vertical-align: top
            }

            .tg .tg-0pky {
                border-color: inherit;
                text-align: left;
                vertical-align: top
            }

            .tg .tg-7btt {
                border-color: inherit;
                font-weight: bold;
                text-align: center;
                vertical-align: top
            }
        </style>

        <table class="tg">
            <thead>
                <tr>
                    <th class="tg-p8sp" colspan="7"><span style="font-weight:bold">Exam Result</span></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="tg-fymr" colspan="2">Exam Name :</td>
                    <td class="tg-0pky" colspan="5"><?php echo $exam['examName'] ?></td>
                </tr>
                <tr>
                    <td class="tg-fymr" colspan="2">Course Name :</td>
                    <td class="tg-0pky" colspan="5"><?php echo $exam['courseName'] ?></td>
                </tr>
                <tr>
                    <td class="tg-0pky" colspan="2"><span style="font-weight:bold">Date :</span></td>
                    <td class="tg-0pky" colspan="5"><?php echo $exam['examDate'] ?></td>
                </tr>
              
                <tr>
                    <td class="tg-0pky" colspan="7"></td>
                </tr>
                <tr>
                    <td class="tg-7btt">Sr. No</td>
                    <td class="tg-7btt">Student ID</td>
                    <td class="tg-7btt" style="width:250px">Name</td>
                    <td class="tg-7btt">Theory Marks <br>(Out Of <?php echo $exam['totalMarks']?>)</td>
                    <td class="tg-7btt">Practical Marks<br>(Out Of <?php echo $exam['practicalMarks']?>)</td>
                    <td class="tg-7btt">Percentage</td>
                    <td class="tg-7btt" style="width:80px">Result</td>
                </tr>
                <?php foreach ($result_arr as $sr => $result) { ?>
                    <tr>
                        <td class="tg-c3ow"><?php echo $sr + 1 ?></td>
                        <td class="tg-0pky"><?php echo $result['studentId'] ?></td>
                        <td class="tg-0pky"><?php echo $result['uname'] ?></td>
                        <td class="tg-c3ow"><?php echo $result['marksObtain'] + 0 ?></td>
                        <td class="tg-c3ow"><?php echo $result['practicalMarksObtain'] + 0 ?></td>
                        <td class="tg-c3ow"><?php echo $result['percentObtain'] + 0 ?></td>
                        <td class="tg-c3ow"><?php echo $result['result'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
<?php
        }
    } ?>