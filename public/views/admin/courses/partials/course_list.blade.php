<!--  ***************************** Course List ***************************  -->
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Course List</h3>
    </div>
    <div class="box-body course-list-container">
        <table ng-table="tableCourseList" class="table table-hover" show-filter="true">
            <tr ng-repeat="course in $data">
                <td title="'Description'" sortable="description" filter="{description: 'text'}">
                    <form novalidate ng-submit="saveUpdateCourse($index)" ng-model-options="{updateOn : 'submit'}">
                        <div class="row">
                            <div class="col-md-8">

                                <!--#start Edit course section -->
                                <div ng-if="course.edit">
                                    <input type="text" class="form-control" name="edit-description" id="edit-description" ng-model="course.description">
                                </div>
                                <!-- #end -->

                                <!-- #start Display course description section -->
                                <div ng-if="!course.edit">
                                    @{{course.description}}
                                </div>
                                <!-- #end -->

                            </div>
                            <div class="col-md-4">

                                <!-- #start Update course information buttons section -->
                                <div ng-if="course.edit">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>
                                    <button type="button" class="btn btn-warning" ng-click="course.edit = !course.edit"><i class="fa fa-ban"></i> Cancel</button>
                                </div>
                                <!-- #end -->

                                <!-- #start Default course buttons section -->
                                <div ng-if="!course.edit">
                                    <button type="button" class="btn btn-success" ng-click="course.edit = !course.edit"><i class="fa fa-edit"></i> Edit</button>
                                    <button type="button" class="btn btn-danger" ng-click="deleteCourse($index)"><i class="fa fa-trash"></i> Remove</button>
                                </div>
                                <!-- #end -->

                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
    </div>
</div>
<!--  ******************************************************************************  -->