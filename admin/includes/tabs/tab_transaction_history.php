<!-- Add New Department Tab -->
<div class="tab-pane fade" id="tab_transaction_history" role="tabpanel" aria-labelledby="#accounts-tab3">
    <table id="example3" class="" data-toggle="table" data-search="true" data-sort-name="timestamp" data-pagination="true">
        <thead>
            <tr>
                <th data-sortable="true">Transaction ID</th>
                <th data-sortable="true">Time</th>
                <th data-sortable="true">Status</th>
                <th data-sortable="true">Reg. ID</th>
                <th data-sortable="true">Transaction Amount</th>
                <th data-sortable="true">Mode of Payment</th>
                <th data-sortable="true">Contact no</th>
                <th data-sortable="true">Email</th>
                <th data-field="timestamp" data-sortable="true" data-visible="false">timestamp</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $transaction = DB::query("SELECT transactions.id, datetime, status, studentId, txnAmount, paymentMode, mobile, email
                                    FROM transactions 
                                    LEFT JOIN admissions 
                                    ON admissions.id = transactions.studentId

                                    ORDER BY datetime DESC");
            foreach ($transaction as $txn) {
            ?>
                <tr>
                    <td><?php echo $txn['id'] ?></td>
                    <td><?php echo $txn['datetime'] ?></td>
                    <td><?php echo $txn['status'] ?></td>
                    <td><?php echo $txn['studentId'] ?></td>
                    <td><?php echo $txn['txnAmount'] ?></td>
                    <td><?php echo $txn['paymentMode'] ?></td>
                    <td><?php echo $txn['mobile'] ?></td>
                    <td><?php echo $txn['email'] ?></td>
                    <td><?php echo $txn['timestamp'] ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<!-- ./ Add New Department Tab -->