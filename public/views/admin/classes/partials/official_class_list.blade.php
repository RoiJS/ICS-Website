<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Official Student List</h3>
    </div>
    <div ng-show="status.official_student_loading" class="box-header with-border">
        <div class="row" >
            <div class="col-md-12">
                <i class="fa fa-refresh fa-spin"></i> <span> Loading students&hellip; </span>
            </div>
        </div>
    </div>
   
    <div class="box-body class-list-container">

        <div class="callout callout-warning" ng-if="!status.official_student_loading && !status.has_official_list">
            <p><i class="fa fa-warning"></i> <b>Empty official student list.</b> <br> 
            Add student information by selecting student at the left panel.</p>
        </div>

        <table ng-table="tableOfficialClassList" id="tbl-official-student-list" class="table table-hover" show-filter="true" ng-show="!status.official_student_loading && status.has_official_list">
            <tr id="official-student-@{{$index}}" ng-repeat="student in $data">
                <td class="student-id" title="'Student Id'" sortable="student_id" filter="{student_id: 'text'}">@{{student.student_id}}</td>
                <td class="student-name" title="'Student name'" sortable="fullname" filter="{fullname: 'text'}">@{{student.fullname}}</td>
                <td title="''">
                    <button type="button" class="btn btn-danger" ng-click="removeStudentClass($index)"><i class="fa fa-trash"></i></button>
                </td>
            </tr>
        </table>
    </div>
    <div class="box-footer"></div>
</div>