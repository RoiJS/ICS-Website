app.controller('studentEnrollSubjectsController', ['$scope', 'studentEnrollSubjectsService', function ($scope, studentEnrollSubjectsService) {

    var datetimeHelper = $scope.datetimeHelper;
    var dialogHelper = $scope.dialogHelper;
    var userHelper = $scope.userHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var systemHelper = $scope.systemHelper;

    $scope.subjects = [];
    $scope.courses = [];
    $scope.year_levels = [];

    $scope.selectedCourse = 0;
    $scope.selectedYearLevel = 0;

    $scope.tblClassList = null;

    $scope.status = {
        is_subject_set: false,
        subject_loading: false,
        has_curriculum_subjects: false,
        is_subject_sort: false
    }

    displayYearLevels = () => {
        studentEnrollSubjectsService.getCurriculumYearLevels().then((year_levels) => {
            $scope.year_levels = year_levels;
        });
    }

    displayCourses = () => {
        studentEnrollSubjectsService.getCourses().then((res) => {
            $scope.courses = res.data.courses;
        });
    }

    displaySubjects = (callback) => {

        $scope.status.subject_loading = true;
        var selectedCourse = parseInt($("#selected_course").val());
        var selectedYearLevel = parseInt($("#selected_year_level").val());

        studentEnrollSubjectsService.getSubjects(selectedCourse, selectedYearLevel).then((res) => {
            $scope.status.subject_loading = false;
            $scope.subjects = res.data.subjects;
            $scope.status.has_curriculum_subjects = !!$scope.subjects.length;

            $scope.subjects.map((subject) => {
                if (subject.start_time && subject.end_time) {
                    subject.start_time = datetimeHelper.timeParseReverse(subject.start_time);
                    subject.end_time = datetimeHelper.timeParseReverse(subject.end_time);
                }
                subject.teacher_name = userHelper.getPersonFullname(subject);
                subject.subject_name = systemHelper.trimString(subject.subject_description);
                subject.subject_schedlule = displayDays(subject);
                subject.start_time = datetimeHelper.timeParse(subject.start_time);
                subject.end_time = datetimeHelper.timeParse(subject.end_time);
            });

            $scope.tblClassList = dataTableHelper.initializeDataTable({}, {
                dataset: $scope.subjects
            });

            if (callback) callback();
        });
    }

    load = () => {
        displayYearLevels();
        displayCourses();
        displaySubjects(() => {
            systemHelper.removePageLoadEffect();
        });
    }

    displayDays = (subject) => {
        var days = [];

        if (subject.monday) {
            days.push("Mon");
        }

        if (subject.tuesday) {
            days.push("Tue");
        }

        if (subject.wednesday) {
            days.push("Wed");
        }

        if (subject.thursday) {
            days.push("Thu");
        }

        if (subject.friday) {
            days.push("Fri");
        }

        if (subject.saturday) {
            days.push("Sat");
        }

        return days.join().toString();
    }

    /**
     * TODO:
     *  (2) Extract static texts
     */
    $scope.enrollSubject = (index) => {

        var subjectList = $scope.tblClassList.data;
        var class_id = subjectList[index].class_id;

        var title = 'Enroll subject';
        var message = 'Are you sure to enroll this subject?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                studentEnrollSubjectsService.enrollSubject(class_id).then((res) => {
                    if (res.data.status === true) {
                        subjectList[index].is_enrolled = 0;
                    }
                });
            }
        });
    }

    /**
     * TODO:
     *  (1) Extract static texts
     */
    $scope.unenrollSubject = (index) => {

        var subjectList = $scope.tblClassList.data;
        var class_id = subjectList[index].class_id;

        var title = 'Unenroll subject';
        var message = 'Are you sure to unenroll this subject?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if(result) {
                studentEnrollSubjectsService.unenrollSubject(class_id).then((res) => {
                    if (res.data.status === true) {
                        subjectList[index].is_enrolled = -1;
                    }
                });
            }
        });
    }

    $scope.filterSubjects = () => {
        displaySubjects();
    }

    load();
}]);