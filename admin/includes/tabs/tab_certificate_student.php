<?php
?>
<!-- Add New Department Tab -->
<div class="tab-pane fade" id="tab-cert-stud" role="tabpanel">
    <table id="example2" class="" data-toggle="table" data-search="true" data-pagination="true">
        <thead class="">
            <tr>

                <th data-sortable="true">Profile</th>
                <th data-sortable="true">Reg. ID</th>
                <th data-sortable="true">Enrollment ID</th>
                <th data-sortable="true">Student Name</th>
                <th data-sortable="true">Course</th>
                <th data-sortable="true">Referred By</th>
                <th data-sortable="true">Date of Admission</th>
                <th data-sortable="true">Course Duration(months)</th>
                <th data-sortable="true">Date of completion</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // foreach ($diploma as $d) {
            $certStudent = DB::query("SELECT admissions.id,uname,courses_enrolled.id as ceid,name,doa,duration,doc FROM courses_enrolled 
                                    INNER JOIN courses
                                    ON courses.id = courses_enrolled.courseId
                                    RIGHT JOIN admissions
                                    ON admissions.id = studentId
                                   
                                    WHERE courseType='Certification'");
            // echo "<pre>";
            // print_r($certStudent);
            // echo "</pre>";
            foreach ($certStudent as $s) {  ?>
                <tr>
                    <td class="text-center"><a target="_blank" href="./user_profile.php?u=<?php echo $s['id'] ?>" class="badge badge-primary"><i class="fas fa-eye"></i> View</a></td>
                    <td><?php echo $s['id'] ?></td>
                    <td><?php echo $s['ceid'] ?></td>
                    <td><?php echo $s['uname'] ?></td>
                    <td><?php echo $s['name'] ?></td>
                    <?php
                    $refBy =  DB::queryFirstRow("select referredBy from usrregistration where registrationId = %s", $s['id']);
                    if($refBy['referredBy'] == null)
                        $refName['name']="-";
                    else
                        $refName = DB::queryFirstRow("select name from usrregistration where referralCode=%s", $refBy['referredBy']);
                    ?>
                    <td><?php echo $refName['name'] ?></td>
                    <td><?php echo $s['doa'] ?></td>
                    <td><?php echo $s['duration'] ?></td>
                    <td><?php echo $s['doc'] ?></td>
                </tr>
            <?php }
            //F} 
            ?>
        </tbody>
    </table>
</div>
<!-- ./ Add New Department Tab -->