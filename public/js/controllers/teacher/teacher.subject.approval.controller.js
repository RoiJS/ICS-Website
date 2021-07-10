app.controller('teacherSubjectApprovalController', ['$scope', 'teacherSubjectApprovalService', function ($scope, teacherSubjectApprovalService) {

    var systemHelper = $scope.systemHelper;
    var userHelper = $scope.userHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;
    var notificationHelper = $scope.notificationHelper;

    $scope.subjects_approval = [];
    $scope.sp_count = 0;

    $scope.status = {
        data_loading: false,
        has_data: false
    }

    displaySubjectsApproval = () => {
        $scope.status.data_loading = true;
        teacherSubjectApprovalService.getSubjectApproval().then((res) => {
            $scope.status.data_loading = false;
            $scope.subjects_approval = res.data.subjects;
            $scope.sp_count = $scope.subjects_approval.length;
            $scope.status.has_data = $scope.subjects_approval.length > 0;

            $scope.subjects_approval.map(s => {
                s.requester_name = systemHelper.trimString(userHelper.getPersonFullname(s), 28);
                s.request_date = datetimeHelper.parseDate(s.requested_at);
            });
        });
    }

    $scope.approveSubject = (index) => {
        var class_list_id = $scope.subjects_approval[index].class_list_id;

        var title = "Approve request";
        var message = "Are you sure to approve selected request?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                teacherSubjectApprovalService.approveSubject(class_list_id).then((res) => {
                    if (res.data.status) {
                        activityLogHelper.registerActivity(`Enroll Request: Approved enroll request.`).then(status => {
                            if (status) {
                                notificationHelper.registerNotification(getApproveRequestNotificationObject(index)).then(status => {
                                    $scope.subjects_approval.splice(index, 1);
                                    $scope.$apply();
                                });
                            }
                        });
                    }
                });
            }
        });
    }

    getApproveRequestNotificationObject = (index) => {

        var details = $scope.subjects_approval[index];
        var student_id = details.stud_id;
        var subject_name = details.subject_description;
        var subject_code = details.subject_code;
        var class_id = details.class_id;

        var description = `Your request to enroll on class (${subject_code}) ${subject_name} has been approved.`;
        var path = notificationHelper.notificationPaths.studentClass(class_id);

        return {
            notify_to: student_id,
            notify_to_user_type: 'student',
            description: description,
            path: path
        }
    }

    displaySubjectsApproval();
}]);