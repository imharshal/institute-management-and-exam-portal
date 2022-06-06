<div class="tab-pane fade" role="tabpanel" id="tab_verify_transaction">
    <form  method="post">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="">Transation Id</label>
                    <input type="text" class="form-control" name="ORDER_ID" id="order_id">  
                </div>

                <center><button type="button" id="btn-fetch-txn" class="btn btn-primary btn-lg " style="vertical-align: center ;">Fetch Transaction</button> </center>
            <br>
            <table class="table table-hover" >
            <tbody id="fetch-result">
            </tbody>
            </table>
            </div>
            
        </div>
    </form>



</div>