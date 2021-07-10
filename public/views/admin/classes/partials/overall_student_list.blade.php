<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Student List</h3>
    </div>
    <div class="box-header with-border">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                <div class="form-group">
                    <label>Students:</label>
                    <select id="student" onchange="sortOverallStudentList(this)" class="form-control select-model" ng-model="class.student" ng-options="student.student_id + ' - ' + userHelper.getPersonFullname(student) for student in students_list_options track by student.stud_id"  style="width:100%;"></select>
                </div>
            </div>
        </div>
    </div>
    <div ng-show="status.students_loading" class="box-header with-border">
        <div class="row" >
            <div class="col-md-12">
                <i class="fa fa-refresh fa-spin"></i> <span> Loading students&hellip; </span>
            </div>
        </div>
    </div>
    <div class="box-body loan-subjects-container">
        <table ng-show="!status.students_loading" class="table table-hover">
            <thead>
                <tr>
                    <th>Student ID</th>
                    <th>Student name</th>
                    <th></th>
                </tr>
            </thead>

            <!-- #start Empty overall student list template -->
            <tbody ng-if="!status.has_students">
                <tr>
                    <td colspan=9 class="text-red">
                        <div class="callout callout-warning">
                            <p><i class="fa fa-warning"></i> <b>Empty student list.</b> <br> 
                            Go to 'Student List' page to add student.</p>
                        </div>
                    </td>
                </tr>
            </tbody>
            <!-- #end -->

            <!-- #start Overall student list template -->
            <tbody ng-if="status.has_students">
                <tr id="overall-student-@{{$index}}" ng-repeat="student in students">
                    <td class="student-id">@{{student.student_id}}</td>
                    <td class="student-name">@{{userHelper.getPersonFullname(student)}}</td>
                    <td>
                        <button ng-if="student.is_active === 1" type="button" class="btn btn-success" ng-click="addStudentClass($index)"><i class="fa fa-arrow-right"></i></button>
                        <span ng-if="student.is_active === 0" class="label label-warning">Inactive</span>
                    </td>
                </tr>
            </tbody>
            <!-- #end -->
            
        </table>
    </div>
    <div class="box-footer"></div>
</div>