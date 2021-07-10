<!-- ********************* Create new course form ******************* -->
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Course Form</h3>
    </div>
    <form novalidate name="courseForm" ng-submit="saveNewCourse()" ng-model-options="{updateOn : 'submit'}">
        <div class="box-body course-form-container">
            <div class="form-group course-name-field">
                <label for="description">Course Name:</label>
                <input type="text" class="form-control" ng-model="course.description" name="description" id="courseName" placeholder="Enter course name&hellip;">
            </div>
            <div class="form-group save-course-button">
                <button type="submit" class="btn btn-success" ><i class="fa fa-save"></i> Save</button>
            </div>
        </div>
    </form>
</div>
<!-- **************************************************************** -->
