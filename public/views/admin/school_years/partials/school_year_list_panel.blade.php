<!-- #start School year list section  -->
<div class="box-body " >
    <div class="row" ng-if="data.loading">
        <div class="col-md-12">
            <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
        </div>
    </div>

    <div class="school-year-container" ng-if="!data.loading">
        <table class="table table-hover">   
            <tbody>
                <tr ng-repeat="school_year in school_years | orderBy : school_year.sy_from ">
                    <td style="width:55%;">
                        <div class="row" ng-if="!school_year.edit">
                            <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                                @{{getSchoolYear(school_year)}}
                            </div>
                            <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                <input type="checkbox" title="Set as default" ng-model="school_year.is_current_sy" ng-checked="school_year.is_current_sy === 1" ng-click="setCurrentSchoolyear($index)">
                                <button class="btn btn-success" ng-click="school_year.edit = !school_year.edit"><i class="fa fa-edit"></i></button>
                                <button class="btn btn-danger" ng-click="removeSchoolYear($index)"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        
                        <div class="row" ng-if="school_year.edit">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <select class="form-control" ng-change="setYearEndEdit($index)" ng-model="school_year.sy_from" ng-options="year for year in [] | range: year_start: year_end"></select>
                                    </div>
                                </div>  
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="form-group">
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <select class="form-control" ng-change="setYearStartEdit($index)"  ng-model="school_year.sy_to" ng-options="year for year in [] | range: year_start: year_end"></select>
                                    </div>
                                </div>       
                            </div>
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <button class="btn btn-primary btn-block" ng-click="saveUpdateSchoolYear($index)"><i class="fa fa-save"></i> Save</button>
                                <button class="btn btn-warning btn-block" ng-click="school_year.edit = !school_year.edit"><i class="fa fa-ban" ></i> Cancel</button>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<!-- #end -->
