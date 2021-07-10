<div class="box box-success">
    <div class="box-body">
        <div class="row">
            <div class="col-md-12">
                <div class="class-details-options-panel">
                    <div class="panel-field course-field">
                        <div class="form-group">
                            <label>Course:</label><br>
                            <select id="course" onchange="sortSubject()" class="form-control select-model" ng-model="class.course" ng-options="course.description for course in courses track by course.course_id"></select>
                        </div>
                    </div>
                    <div class="panel-field curriculum-field">
                        <div class="form-group">
                            <label>Curriculum Year:</label><br>
                            <select id="curriculum_school_year" 
                                    onchange="sortSubject()" 
                                    class="form-control select-model" 
                                    ng-model="class.curriculum_school_year" 
                                    ng-options="cy.curriculum_year for cy in curriculum_years track by cy.curriculum_year"></select>
                        
                            <!-- <datalist id="curriculum_years">
                                <option ng-repeat="cy in curriculum_years" value="@{{cy.curriculum_year}}"></option>
                            </datalist>
                            <input type="text" 
                                    id="curriculum_school_year" 
                                    onchange="sortSubject()"
                                    class="form-control" 
                                    ng-model="class.curriculum_school_year"
                                    list="curriculum_years" /> -->
                        </div>
                    </div>
                    <div class="panel-field subject-field">
                        <div class="form-group" ng-show="!status.is_subject_sort">
                            <label>Subject:</label><br>
                            <select id="subject" class="form-control select-model" ng-model="class.subject" ng-options="subject.subject_details for subject in curriculum_subjects track by subject.subject_details_id"></select>
                        </div>
                        <div class="form-group" ng-show="status.is_subject_sort">
                            <label>Subjects:</label><br>
                            <i class="fa fa-refresh fa-spin"></i> Loading subjects&hellip;
                        </div>
                    </div>
                    <div class="panel-field section-field">
                        <div class="form-group">
                            <label>Section:</label><br>
                            <select id="section" class="form-control select-model" ng-model="class.section" ng-options="section.section for section in sections track by section.section"></select>
                        </div>  
                    </div>
                    <div class="panel-field current-sem-field">
                        <label>Sem:</label>
                        <h4>@{{c_sem}}</h4>
                    </div>
                    <div class="panel-field current-school-year-field">
                        <label>School Year:</label>
                        <h4>@{{c_sy}}</h4>
                    </div>
                    <div class="panel-field set-class-details-field">
                        <div class="form-group">
                            <br>
                            <button class="btn btn-success" ng-click="setClassDetails()"><i class="fa fa-check"></i> Set</button>     
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>