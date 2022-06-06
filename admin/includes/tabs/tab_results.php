<div class="tab-pane active" role="tabpanel" id="tab-results">
    <!-- <form target="_blank" action="result_generator.php" method="post"> -->
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Department</label>
                <select class="form-control" id="dept">
                    <option >Select</option>
                    <option value="Diploma">Diploma</option>
                    <option value="Certification">Certification</option>
                </select>
            </div>

            <div class="form-group">
                <label for="">Course</label>
                <select class="form-control" id="courses">

                </select>
            </div>
            <input type="hidden" name="print" value="true">
            <div class="form-group">
                <label for="">Exam</label>
                <select class="form-control" name="examid" id="exams">

                </select>
            </div>
            <button id="fetch-button" class="btn btn-primary btn-lg float-right" style="vertical-align: center ;">Fetch Results</button>
        </div>

    </div>
    <!-- </form> -->



</div>