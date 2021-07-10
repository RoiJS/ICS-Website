<div class="box box-success" >
    <div class="box-header with-border">
        <h3 class="box-title"><i class="fa fa-list"></i> Curriculum</h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Course:</label>
                    <select id="course-field" class="form-control" ng-model="selectedCourse" ng-options="course.description for course in courses track by course.course_id"></select>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Year:</label>
                    <datalist id="curriculum_years">
                        <option ng-repeat="cy in curriculum_years" value="@{{cy.curriculum_year}}"></option>
                    </datalist>
                    <input type="text" id="schoolyear-field" class="form-control" ng-model="selectedSchoolYear" list="curriculum_years" />
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <label>Year Level:</label>
                    <select id="yearlevel-field" class="form-control" ng-model="selectedYearLevel" ng-options="year for year in [] | range:1:5"></select>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">    
                    <label>Semester:</label>
                    <select id="semester-field" class="form-control" style="height:40px;" ng-model="selectedSemester" ng-options="semester.semester  for semester in semesters  track by semester.semester_id"></select>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- #start Button options section -->
<div class="row">

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6"></div>
    
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3 set-curriculum-subjects-container">
        <button class="btn btn-success btn-block" ng-click="getCurriculumSubjects();"><i class="fa fa-check"></i> Set</button>  
    </div>
    <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
        <button class="btn btn-warning btn-block" ng-click="resetCurriculumSubjects()"><i class="fa fa-refresh"></i> Reset</button>  
    </div>
</div>
<!-- #end -->
