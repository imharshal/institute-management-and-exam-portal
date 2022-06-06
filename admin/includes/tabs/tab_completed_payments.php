<!-- Department Tab -->
<div class="tab-pane fade " id="tab_completed_payments" role="tabpanel" aria-labelledby="#accounts-tab2">
    <div class="card-body p-0">
        <table id="example2" class="" data-toggle="table" data-sort-name="timestamp" data-search="true" data-pagination="true">
            <thead class="">
                <tr>
                    <th data-sortable="true">Enroll. ID</th>
                    <th data-sortable="true">Reg. ID</th>
                    <th data-sortable="true">Name</th>
                    <th data-sortable="true">Course</th>
                    <th data-sortable="true">Total fees</th>
                    <th data-sortable="true">No. of Installments</th>
                    <th data-sortable="true">Fees paid</th>
                    <th data-sortable="true">Remaining Fees</th>
                    <th data-field="timestamp" data-sortable="true" data-visible="false">timestamp</th>


                </tr>
            </thead>
            <tbody>
                <?php
                $pendings = DB::query("SELECT payment_status.id,studentId,uname,name,feesPayable,installmentsTaken,feesPaid,feesRemain,ps_timestamp FROM payment_status
                                    RIGHT JOIN courses_enrolled
                                    ON courses_enrolled.id = payment_status.id
                                    RIGHT JOIN courses
                                    ON courseId = courses.id
                                    RIGHT JOIN admissions
                                    ON studentId = admissions.id
                                    WHERE status=%s", 'Completed');

                foreach ($pendings as $pnd) {
                ?>
                    <tr>
                        <td><?php echo $pnd['id'] ?></td>
                        <td><?php echo $pnd['studentId'] ?></td>
                        <td><?php echo $pnd['uname'] ?></td>
                        <td><?php echo $pnd['name'] ?></td>
                        <td><?php echo $pnd['feesPayable'] ?></td>
                        <td><?php echo $pnd['installmentsTaken'] ?></td>
                        <td><?php echo $pnd['feesPaid'] ?></td>
                        <td><?php echo $pnd['feesRemain'] ?></td>
                        <td><?php echo $pnd['ps_timestamp'] ?></td>
                    </tr>
                <?php } ?>
            </tbody>

        </table>
    </div>
</div>
<!--./ Department Tab -->