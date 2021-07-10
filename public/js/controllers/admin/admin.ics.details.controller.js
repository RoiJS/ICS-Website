app.controller('icsDetailsController', ['$scope', 'adminICSDetailsService', function ($scope, adminICSDetailsService) {

    var systemHelper = $scope.systemHelper;
    var dialogHelper = $scope.dialogHelper;
    var activityLogHelper = $scope.activityLogHelper;

    var rendering = 'Loading...';

    $scope.edit = {
        address: false,
        tel_number: false,
        email_address: false
    };

    $scope.details = {
        mission: rendering,
        vision: rendering,
        goals: rendering,
        objectives: rendering,
        history: rendering,
        address: rendering,
        tel_number: rendering,
        email_address: rendering,
        organization_name: rendering,
        logo: null
    }

    adminICSDetailsService.getDetails().then((res) => {
        $scope.details = {
            mission: res.data.details.mission,
            vision: res.data.details.vision,
            goals: res.data.details.goals,
            objectives: res.data.details.objectives,
            history: res.data.details.history,
            address: res.data.details.address,
            tel_number: res.data.details.tel_number,
            email_address: res.data.details.email_address,
            organization_name: res.data.details.organization_name
        }
    });

    systemHelper.getOfficialLogo();

    $scope.saveNewAddress = () => {
        if ($scope.addressForm.$valid) {

            var title = 'Update details';
            var message = 'Are you sure to update address detail?';

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    $scope.edit.address = false;
                    adminICSDetailsService.saveNewDetails('address', $scope.details.address).then(res => {
                        activityLogHelper.registerActivity(`ICS Details: Updated address.`).then(status => {
                            dialogHelper.showSuccess("Address has been successfully saved");
                        });
                    }, (err) => {
                        dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                    });
                }
            });
        }
    }

    $scope.saveNewTelNumber = () => {
        if ($scope.telNumberForm.$valid) {
            var title = 'Update details';
            var message = 'Are you sure to update telephone number?';

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    $scope.edit.tel_number = false;
                    adminICSDetailsService.saveNewDetails('tel_number', $scope.details.tel_number).then(res => {
                        activityLogHelper.registerActivity(`ICS Details: Updated telephone number.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess("Telephone number has been successfully saved");
                            }
                        });
                    }, (err) => {
                        dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                    });
                }
            });
        }
    }

    $scope.saveNewEmailAddress = () => {
        if ($scope.emailAddressForm.$valid) {

            var title = 'Update details';
            var message = 'Are you sure to update email address?';

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    $scope.edit.email_address = false;
                    adminICSDetailsService.saveNewDetails('email_address', $scope.details.email_address).then(res => {
                        activityLogHelper.registerActivity(`ICS Details: Updated email address.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess("Email address has been successfully saved");
                            }
                        });
                    }, (err) => {
                        dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                    });
                }
            });
        }
    }

    $scope.saveNewOrganizationName = () => {
        if ($scope.emailAddressForm.$valid) {
            var title = 'Update details';
            var message = 'Are you sure to update organization name?';

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    $scope.edit.organization_name = false;
                    adminICSDetailsService.saveNewDetails('organization_name', $scope.details.organization_name).then(res => {
                        activityLogHelper.registerActivity(`ICS Details: Updated organization name.`).then(status => {
                            if (status) {
                                dialogHelper.showSuccess("Organization name has been successfully saved");
                            }
                        });
                    }, (err) => {
                        dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                    });
                }
            });
        }
    }

    $scope.saveNewMission = () => {
        var title = 'Update details';
        var message = 'Are you sure to update mission?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminICSDetailsService.saveNewDetails('mission', $('.mission').val()).then(res => {
                    activityLogHelper.registerActivity(`ICS Details: Updated mission content.`).then(status => {
                        if (status) {
                            dialogHelper.showSuccess("Mission has been successfully saved");
                        }
                    });
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                });
            }
        });
    }

    $scope.saveNewVision = () => {
        var title = 'Update details';
        var message = 'Are you sure to update vision?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminICSDetailsService.saveNewDetails('vision', $('.vision').val()).then(res => {
                    activityLogHelper.registerActivity(`ICS Details: Updated telephone vision content.`).then(status => {
                        if (status) {
                            dialogHelper.showSuccess("Vision has been successfully saved");
                        }
                    });
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                });
            }
        });
    }

    $scope.saveNewGoals = () => {
        var title = 'Update details';
        var message = 'Are you sure to update goals?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminICSDetailsService.saveNewDetails('goals', $('.goals').val()).then(res => {
                    activityLogHelper.registerActivity(`ICS Details: Updated goals content.`).then(status => {
                        if (status) {
                            dialogHelper.showSuccess("Goals has been successfully saved");
                        }
                    });
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                });
            }
        });
    }

    $scope.saveNewObjectives = () => {
        var title = 'Update details';
        var message = 'Are you sure to update objectives?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminICSDetailsService.saveNewDetails('objectives', $('.objectives').val()).then(res => {
                    activityLogHelper.registerActivity(`ICS Details: Updated objectives content.`).then(status => {
                        if (status) {
                            dialogHelper.showSuccess("Objectives has been successfully saved");
                        }
                    });

                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                });;
            }
        });
    }

    $scope.saveNewHistory = () => {
        var title = 'Update details';
        var message = 'Are you sure to update history?';

        dialogHelper.showConfirmation(title, message, (result) => {
            if (result) {
                adminICSDetailsService.saveNewDetails('history', $('.history').val()).then(res => {
                    activityLogHelper.registerActivity(`ICS Details: Updated history content.`).then(status => {
                        if (status) {
                            dialogHelper.showSuccess("History has been successfully saved");
                        }
                    });
                }, (err) => {
                    dialogHelper.showError("Error occured", "Failed to save. Please try again later.");
                });
            }
        });
    }

    $scope.saveNewLogo = () => {
        if ($scope.details.logo != null) {
            var title = 'Update details';
            var message = 'Are you sure to save new logo?';

            dialogHelper.showConfirmation(title, message, (result) => {
                if (result) {
                    adminICSDetailsService.saveNewLogo($scope.details.logo).then((res) => {
                        if (res.data.status === 1) {
                            activityLogHelper.registerActivity(`ICS Details: Updated organization logo.`).then(status => {
                                if (status) {
                                    dialogHelper.showSuccess("Selected image has been set as new ics logo.", () => {
                                        window.location.reload();
                                    });
                                }
                            });
                        }
                    });
                }
            });
        } else {
            dialogHelper.showError('No image', 'Missing image. Please select an image.');
        }
    }
}]);