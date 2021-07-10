<div class="box-body">
    <div class="row" ng-if="data.loading">
        <div class="col-md-12">
            <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
        </div>
    </div>

    <div class="semester-container" ng-if="!data.loading">
        <table class="table table-hover">
            <tbody>
                <tr ng-repeat="semester in semesters">
                    <td style="width:55%;">
                        <form ng-submit="saveUpdateSemester($index)" ng-model-options="{updateOn : 'submit'}">
                            <div class="row">
                                <div class="col-md-8">
                                    <div ng-if="!semester.edit">
                                        @{{semester.semester}}
                                    </div>
                                    <div ng-if="semester.edit">
                                        <input type="text" ng-model="semester.semester" class="form-control" name="semester" id="update-semester" ng-model-options="{updateOn : '$inherit'}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div ng-if="!semester.edit">
                                        <input type="checkbox" title="Set as default" ng-model="semester.is_current_semester" ng-checked="semester.is_current_semester === 1" ng-click="saveCurrentSemester($index)">
                                        <button type="button" class="btn btn-success" ng-click="semester.edit = !semester.edit"><i class="fa fa-edit"></i></button>
                                        <button type="button" class="btn btn-danger" ng-click="removeSemester($index)"><i class="fa fa-trash"></i></button>
                                    </div>  
                                    <div ng-if="semester.edit">   
                                        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i></button>
                                        <button type="button" class="btn btn-warning" ng-click="semester.edit = !semester.edit"><i class="fa fa-ban" ></i></button>
                                    </div>    
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>