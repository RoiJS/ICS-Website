<!-- #start Add semester section -->
<div class="box-footer">
    <form novalidate ng-submit="saveNewSemester()">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <input type="text" ng-model="semester.semester" placeholder="Enter semester&hellip;" name="new-semester" id="new-semester" class="form-control" >
                </div>       
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" class="btn btn-success col-xs-12 col-sm-12 col-md-12 col-lg-12"><i class="fa fa-save"></i> Save New Semester</button>
            </div>
        </div>
    </form>
</div>
<!-- #end -->