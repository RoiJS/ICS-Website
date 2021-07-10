app.controller('teacherViewHomeworksController', ['$scope', 'accountHomeworksService', function ($scope, accountHomeworksService) {

    var systemHelper = $scope.systemHelper;
    var imageFileHelper = $scope.imageFileHelper;
    var userHelper = $scope.userHelper;
    var datetimeHelper = $scope.datetimeHelper;
    var dataTableHelper = $scope.dataTableHelper;
    var dialogHelper = $scope.dialogHelper;
    var notificationHelper = $scope.notificationHelper;

    $scope.submitted_homeworks = [];

    $scope.tableSubmittedHomeworks = null;

    $scope.status = {
        submitted_homeworks_loading: false,
        has_submitted_homeworks: false
    }

    displaySubmittedHomeworks = (callback) => {
        $scope.status.submitted_homeworks_loading = true;
        accountHomeworksService.getSubmittedHomeworks(homework_id).then((res) => {
            $scope.status.submitted_homeworks_loading = false;
            $scope.submitted_homeworks = res.data.submitted_homeworks;

            $scope.submitted_homeworks.map(function (homework) {
                homework.original_file_name = systemHelper.trimString(homework.original_file_name || "", 25);
                homework.approved_status = (homework.approved_status === 1);
                homework.file = `${imageFileHelper.getFileSrc().homeworks.submitted}${(homework.generated_file_name || "")}`;
                homework.student_name = userHelper.getPersonFullname(homework);
                homework.date_submitted = datetimeHelper.parseDate(homework.date_submitted);
            });

            $scope.status.has_submitted_homeworks = ($scope.submitted_homeworks.length > 0);

            $scope.tableSubmittedHomeworks = dataTableHelper.initializeDataTable({}, {
                dataset: $scope.submitted_homeworks
            });

            if (callback) callback();
        });
    }

    $scope.approvedHomework = (index) => {

        var submitted_homework_list = $scope.tableSubmittedHomeworks.data;
        var submitted_homework_id = submitted_homework_list[index].submitted_homework_id;
        var approved_status = submitted_homework_list[index].approved_status;
        accountHomeworksService.approvedHomework(submitted_homework_id, approved_status).then(status => {
            if (status) {
                notificationHelper.registerNotification(getApproveDisapproveHomeworkNotificationObj(index));
            }
        }, err => {
            dialogHelper.showError('Failed occured', 'Failed to approved homework. Please try again later.');
        });
    }

    getApproveDisapproveHomeworkNotificationObj = (index) => {

        var submitted_homework_list = $scope.tableSubmittedHomeworks.data;
        var student_id = submitted_homework_list[index].stud_id;
        var homework_id = submitted_homework_list[index].homework_id;
        var homework_title = submitted_homework_list[index].title;

        var notify_to = student_id;
        var status = submitted_homework_list[index].approved_status === true ? "Approved" : "Disapproved";
        var description = `${status} your submitted answer for homework '${homework_title}'`;
        var path = notificationHelper.notificationPaths.studentHomework(ClassGlobalVariable.currentClassId, homework_id);

        return {
            notify_to: notify_to,
            notify_to_user_type: 'student',
            description: description,
            path: path,
        }
    }

    $scope.approveAllHomeworks = (status) => {

        var title = status ? "Approve all" : "Disapprove all";
        var message = status ? "Are you sure to approve all homeworks?" : "Are you sure to disapprove all homeworks?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                var submitted_homework_list = $scope.tableSubmittedHomeworks.data;
                for (var pos = 0; pos < submitted_homework_list.length; pos++) {
                    var submitted_homework_id = submitted_homework_list[pos].submitted_homework_id;
                    submitted_homework_list[pos].approved_status = status;
                    accountHomeworksService.approvedHomework(submitted_homework_id, status);
                    $scope.$apply();
                }

                notificationHelper.registerApprovedDisapprovedHomeworkNotification(getApprovedDisapprovedHomeworkNotificationObject(status));
            }
        });
    }

    getApprovedDisapprovedHomeworkNotificationObject = (status) => {

        var statusTitle = status === true ? "Approved" : "Disapproved";
        var homework_title = $(`div.view-homework-panel h3.box-title`).text();
        var description = `${statusTitle} your submitted answer for homework '${homework_title}'`;
        var path = notificationHelper.notificationPaths.studentHomework(ClassGlobalVariable.currentClassId, homework_id);

        return {
            homework_id: homework_id,
            description: description,
            path: path
        }
    }

    $scope.downloadAllFiles = () => {

        var submitted_homework_list = $scope.tableSubmittedHomeworks.data;

        var title = "Download all";
        var message = "Are you sure to download all files?";

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                for (var pos = 0; pos < submitted_homework_list.length; pos++) {
                    window.open(submitted_homework_list[pos].file, "_blank");
                }
            }
        });
    }

    $scope.verifyIfAllApproved = () => {
        var submitted_homework_list = $scope.tableSubmittedHomeworks ? $scope.tableSubmittedHomeworks.data : [];
        return submitted_homework_list.find(f => {
            return f.approved_status === true;
        });
    }

    $scope.verifyIfAllDisapproved = () => {
        var submitted_homework_list = $scope.tableSubmittedHomeworks ? $scope.tableSubmittedHomeworks.data : [];
        return submitted_homework_list.find(f => {
            return f.approved_status === false;
        });
    }

    $scope.verifyIfHaveFilesAvailable = () => {
        var submitted_homework_list = $scope.tableSubmittedHomeworks ? $scope.tableSubmittedHomeworks.data : [];
        var verify = submitted_homework_list.find(f => {
            return !!f.file;
        });
        return verify;
    }

    displaySubmittedHomeworks(() => {
        systemHelper.removePageLoadEffect();
    });
}]);