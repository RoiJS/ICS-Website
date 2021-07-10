
<!-- #start School year add section -->
<div class="box-footer">
    <form novalidate ng-submit="saveNewSchoolYear()">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Year from:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <select id="ctrl-year-from" class="form-control" ng-change="setYearEnd()" ng-model="selected_year_start"  ng-options="year for year in [] | range: year_start : year_end"></select>
                    </div>
                </div>       
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Year to:</label>
                    <div class="input-group date">
                        <div class="input-group-addon">
                            <i class="fa fa-calendar"></i>
                        </div>
                        <select id="ctrl-year-to" class="form-control" ng-change="setYearStart()" ng-model="selected_year_end"  ng-options="year for year in [] | range: year_start : year_end"></select>
                    </div>
                </div>       
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <button type="submit" class="btn btn-success col-xs-12 col-sm-12 col-md-12 col-lg-12"><i class="fa fa-save"></i> Save New School Year</button>
            </div>
        </div>
    </form>
    
</div>
<!-- #end -->