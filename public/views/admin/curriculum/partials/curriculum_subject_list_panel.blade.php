<div id="subjects-section" class="box box-success">
    <div class="box-header with-border">
        <div class="header-container">
            <h3 class="box-title"><i class="fa fa-book"></i> Subjects</h3>
            <button class="btn btn-info btn-print-curriculum" ng-click="printCurriculum()">Print</button>
        </div>
    </div>
    <div class="box-body">
        <div class="row" ng-if="!status.is_curriculum_set">
            <div class="col-md-12">
                <div class="callout callout-info">
                    <h4>No subjects have been set yet.</h4>
                    <p>Display list of subjects per curriculum by setting the following fields above.</p>
                </div>
            </div>
        </div>
        <div class="row" ng-show="status.is_curriculum_set">

            <div class="col-md-12">
                <label>Subject list:</label>
                <div id="select-subject-section">
                    <div id="subject-list-section" class="form-group">
                        
                        <select class="form-control curriculum-subjects-list select-model" id="subject_id" ng-model="selectedSubject" ng-options="subject.subject_code + ' - ' + subject.subject_description for subject in subjects track by subject.subject_id" style="width: 100%;"></select>
                    </div>
                    <div id="add-subject-section" class="form-group">
                        <button type="button" ng-click="addNewSubjectInCurriculum()" class="btn btn-success">Add subject <i class="fa fa-arrow-down"></i></button>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <div class="row" ng-if="status.subjects_loading">
            <div class="col-md-12">
                <i class="fa fa-refresh fa-spin"></i> <span> Loading&hellip; </span>
            </div>
        </div>
        <div class="row" ng-if="status.is_curriculum_set && !status.subjects_loading">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="curriculum-subjects-container">
                    <table ng-table="tableCurriculumSubjects" class="table table-hover">
                        <tr ng-if="!hasCurriculumSelected">
                            <td colspan=4 class="text-red">
                                <div class="callout callout-warning">
                                    <p><i class="fa fa-warning"></i> <b>Empty subject list.</b> Add new subject for this curriculum by selecting subject from the list above.</p>
                                </div>
                            </td>
                        </tr>
                        <tr ng-if="hasCurriculumSelected" ng-repeat="subject in $data">
                            <td title="'Code'">@{{subject.subject_code}}</td>
                            <td title="'Description'">@{{subject.subject_description}}</td>
                            <td title="'Lec Units'">@{{subject.lec_units}}</td>
                            <td title="'Lab Units'">@{{subject.lab_units}}</td>
                            <td><button class="btn btn-danger" ng-click="removeCurriculumSubject($index)"><i class="fa fa-trash"></i> Remove</button> </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>