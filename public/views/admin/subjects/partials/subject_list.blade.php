<!-- ******************************** Subect List *************************************** -->

    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">@{{subjTxtsHelper.TABLE_SUBJECT_LIST}}</h3>
        </div>
        <div class="box-body subject-list-container">
            <table ng-table="tableSubjectList" id="table-subjects" class="table table-bordered table-striped table-hover">
                <tr ng-repeat="subject in $data">
                    <td title="'Code'">@{{subject.subject_code}}</td>
                    <td title="'Description'">@{{subject.subject_description}}</td>
                    <td title="'Lec units'">@{{subject.lec_units}}</td>
                    <td title="'Lab units'">@{{subject.lab_units}}</td>
                    <td><a class="btn btn-warning" ng-href="/admin/subjects/edit_subject/@{{subject.subject_id}}"><i class="fa fa-edit"></i></a> </td>
                    <td><button class="btn btn-danger" ng-click="removeSubject($index)"><i class="fa fa-trash"></i></button></td>
                </tr>
            </table>
        </div>
    </div>  
</div>