app.factory('helperService', ['$http', '$filter', '$sce', 'NgTableParams', ($http, $filter, $sce, NgTableParams) => {

    var appService = {

        /**
         * System global helper functions
         */
        SYSTEM: {

            /**
             * Get current active page in browser
             * @return {boolean}
             */
            activePage: (pages) => {
                var is_active = false;
                for (i in pages) {
                    if (pages[i] == window.location.pathname) {
                        is_active = true;
                    }
                }
                return is_active ? 'active' : null;
            },

            errorControlMessageTemplate: (errorMessage) => {
                return '<span class="error-control-message">@message</span>'.replace("@message", errorMessage);
            },

            addInvalidControlProps: (element, message) => {
                element.addClass("error-control");
                $(appService.SYSTEM.errorControlMessageTemplate(message || "Invalid field.")).insertAfter(element);
            },

            removeInvalidControlTemplate: (element) => {
                element.removeClass("error-control");
                element.next().remove();
            },

            /**
             * Display the substring of the string value if more than the limit length specified
             * @return {string}
             */
            trimString: (message, len) => {
                if (message) {
                    var message = message.toString();
                    return message.length > len ? `${message.substr(0, len)}...` : message;
                } else {
                    return "";
                }
            },

            viewStringAsHtml: (str) => {
                return $sce.trustAsHtml(str);
            },

            /**
             * Display modules' counting status
             * @returns {Promise}
             */
            staticStatus: (category) => {
                return $http.post('/helper/static_status', {
                    category
                });
            },

            viewAnnouncementImage: (image) => {
                return image ? appService.IMAGE_FILE.getFileSrc().announcements + image : appService.IMAGE_FILE.getFileSrc().ics_logo + image;
            },

            viewHTMLAsText: (description) => {
                return $filter('htmlToPlaintext')(description)
            },

            /**
             * Display the current official logo
             * @returns {void}
             */
            getOfficialLogo: () => {
                $http.get('/admin/ics_details/official_logo').then((res) => {
                    var image = appService.IMAGE_FILE.getFileSrc().ics_logo + res.data.logo.ics_logo;
                    $('.preview_image').attr('src', image);
                });
            },

            postUnpostModule: (table, column, id, status, track_update_column) => {
                return $http.post('/helper/post_unpost_module', {
                    table,
                    column,
                    id,
                    status,
                    track_update_column
                });
            },

            displayChatImage: (type, image) => {
                if (type === 'teacher') {
                    return appService.IMAGE_FILE.setFacultyImage(image);
                } else {
                    return appService.IMAGE_FILE.setStudentImage(image);
                }
            },

            getCurrentSemester: () => {
                return $http.get('/helper/get_current_semester');
            },

            getCurrentSchoolYear: () => {
                return $http.get('/helper/get_current_school_year');
            },

            playNewMessageSound: () => {
                var audio = new Audio('/assets/account/sounds/new_message.mp3');
                audio.play();
            },

            getICSDetails: () => {
                return $http.get('/helper/get_ics_details');
            },

            scrollToView: (selector) => {
                document.querySelector("#" + selector).scrollIntoView({
                    block: 'start',
                    behavior: 'smooth'
                });
            },

            checkForPendingRequests: () => {

                var i = null;
                // appService.SYSTEM.removeScrollBarDuringInitialLoad();

                i = setInterval(function () {
                    if ($http.pendingRequests.length === 0) {
                        clearInterval(i);
                        appService.SYSTEM.removePageLoadEffect();
                    }
                }, 1000);
            },

            removeScrollBarDuringInitialLoad: () => {
                $("body").css("overflow", "hidden");
            },

            applyScrollBarAfterInitialLoading: () => {
                $("body").css("overflow", "auto");
            },

            removePageLoadEffect: () => {
                $(".app-back-drop").fadeOut(function () {
                    appService.SYSTEM.applyScrollBarAfterInitialLoading();
                });
            },

            getSelectControlValue: ($control) => {
                return $control.val() !== "?" ? $control.val() : ""
            },

            DIALOGS: {

                showConfirmation: (title, message, callback) => {

                    $.Zebra_Dialog({
                        title: title,
                        message: message,
                        type: 'question',
                        buttons: [{
                                caption: 'Yes',
                                callback: function (element) {
                                    callback(true);
                                }
                            },
                            {
                                caption: 'No',
                                callback: function (element) {
                                    callback(false);
                                }
                            },
                        ],
                        overlay_close: false
                    });
                },

                showError: (title, message) => {

                    $.Zebra_Dialog({
                        title: title,
                        message: message,
                        type: 'error',
                        overlay_close: false
                    });
                },

                showSuccess: (message, callback) => {

                    $.Zebra_Dialog({
                        message: message,
                        type: 'information',
                        buttons: [{
                            caption: 'Ok',
                            callback: function () {
                                if (callback) callback();
                            }
                        }],
                        overlay_close: false
                    });
                },

                showRemoveConfirmation: (title, message, callback) => {

                    $.Zebra_Dialog({
                        title: title,
                        message: message,
                        type: 'warning',
                        buttons: [{
                                caption: 'Yes',
                                callback: function (element) {
                                    callback(true);
                                }
                            },
                            'No'
                        ],
                        overlay_close: false
                    });
                },

                showWarningConfirmation: (title, message, callback) => {

                    $.Zebra_Dialog({
                        title: title,
                        message: message,
                        type: 'warning',
                        buttons: [{
                                caption: 'Yes',
                                callback: function (element) {
                                    callback(true);
                                }
                            },
                            'No'
                        ],
                        overlay_close: false
                    });
                }
            }

        },

        /**
         * Datetime related helper functions
         */
        DATETIME: {

            convertToTimeAgo: (datetimeString) => {

                var current_date = new Date();
                var datetime = new Date(datetimeString);
                var diffSeconds = (current_date.getTime() - datetime.getTime()) / 1000;
                var result = "";

                if (diffSeconds < 60) {
                    result = "Just now";
                } else if (diffSeconds > 60 && diffSeconds < 3600) {
                    var value = Math.floor(diffSeconds / 60);
                    var unit = value > 1 ? " minutes ago" : " minute ago";

                    result = value + unit;
                } else if (diffSeconds > 3600 && diffSeconds < 86400) {
                    var value = Math.floor(diffSeconds / 60 / 60);
                    var unit = value > 1 ? " hours ago" : " hour ago";

                    result = value + unit;
                } else {
                    result = appService.DATETIME.parseDate(datetimeString);
                }

                return result;
            },
            /**
             * Display date based on the specified date format
             * @returns {String}
             */
            parseDate: (date, format = 'mediumDate') => {
                if (typeof date != 'object') {
                    return $filter('date')(Date.parse(date), format);
                } else {
                    return '---------------------';
                }
            },

            /**
             * Parse time value to [hour:min] format in order to save value to database
             * @param {time} Date object to be formatted
             * @returns {string} 
             */
            timeParse: (time, isSaveToDB = false) => {
                if (time) {
                    if (!isSaveToDB) {
                        return time.toLocaleTimeString("en-us", {
                            hour: '2-digit',
                            minute: '2-digit'
                        });
                    } else {
                        var hr = time.getHours();
                        var min = time.getMinutes();
                        return `${hr}:${min}`;
                    }

                } else {
                    return "";
                }
            },

            /**
             * Parse time_detail value to valid javascript Date object in order to set datetimepicker value
             * @param {time_detail} string value to be cast to Date datatype
             * @return {Date}
             */
            timeParseReverse: (time_detail) => {
                if (time_detail) {
                    var time = time_detail.split(":");
                    return new Date(1970, 0, 1, parseInt(time[0]), parseInt(time[1]), parseInt(time[2]));
                } else {
                    return "";
                }
            },

            /**
             * Parse t value to [hour:min:AM/PM] format in order to render it on the web page correctly
             * @returns {string}
             */
            timeToString: (t) => {
                if (t) {
                    return t.toLocaleString('en-US', {
                        hour: 'numeric',
                        minute: 'numeric',
                        hour12: true
                    });
                } else {
                    return '';
                }
            },
        },

        /**
         * Images and files related helper functions
         */
        IMAGE_FILE: {

            defaultUserImage: "/assets/account/images/user-default-photo.png",

            getUserImage: (userType, imagePath) => {
                if (userType === 'admin') {
                    return appService.IMAGE_FILE.setAdminImage(imagePath);;
                } else if (userType === 'student') {
                    return appService.IMAGE_FILE.setStudentImage(imagePath);
                } else if (userType === 'teacher') {
                    return appService.IMAGE_FILE.setFacultyImage(imagePath);
                }
            },

            displayDefaultUserImage: () => {
                $('.preview_image').attr('src', appService.IMAGE_FILE.defaultUserImage);
            },

            setAdminImage: (adminImage) => {
                return adminImage ? appService.IMAGE_FILE.getFileSrc().admin + adminImage : appService.IMAGE_FILE.defaultUserImage;
            },

            setStudentImage: (studentImage) => {
                return studentImage ? appService.IMAGE_FILE.getFileSrc().students + studentImage : appService.IMAGE_FILE.defaultUserImage;
            },

            setFacultyImage: (facultyImage) => {
                return facultyImage ? appService.IMAGE_FILE.getFileSrc().faculty + facultyImage : appService.IMAGE_FILE.defaultUserImage;
            },

            getFileSize: (file) => {
                var size = file.size / 1000000;
                return size.toFixed(2);
            },

            /**
             * Get directory path for each module with files
             * @return {Object}
             */
            getFileSrc: () => {

                var main_dir = 'files';

                return {
                    admin: `/${main_dir}/admin/`,
                    announcements: `/${main_dir}/announcements/`,
                    faculty: `/${main_dir}/faculty/`,
                    homeworks: {
                        send: `/${main_dir}/homeworks/send_homeworks/`,
                        submitted: `/${main_dir}/homeworks/submitted_homeworks/`
                    },
                    ics_logo: `/${main_dir}/ics_logo/`,
                    posts: `/${main_dir}/posts/`,
                    students: `/${main_dir}/students/`
                }
            },

            /**
             * Display selected image via input type file
             * @return {void}
             */
            viewImage: (selected_file, verify_dimension = false) => {

                var actual_file = selected_file.files[0];

                var allowed_image_type = ["image/jpeg", "image/png", "image/jpg", "image/gif"];
                var allowed_image_size = 1000000;
                var allowed_maximum_width = 500;
                var allowed_maximum_height = 500;
                var allowed_minimum_width = 250;
                var allowed_minimum_height = 250;

                if (selected_file.value != null || selected_file.value != "") {

                    if (actual_file.type == allowed_image_type[0] ||
                        actual_file.type == allowed_image_type[1] ||
                        actual_file.type == allowed_image_type[2] ||
                        actual_file.type == allowed_image_type[3]) {

                        if (actual_file.size < allowed_image_size) {
                            var reader = new FileReader();
                            reader.onload = function (e) {

                                if (!verify_dimension) {
                                    $('.preview_image').attr('src', e.target.result);
                                } else {
                                    var image = new Image();
                                    image.src = e.target.result;

                                    image.onload = function () {

                                        var width = this.width;
                                        var height = this.height;

                                        if (appService.IMAGE_FILE.isValidImageDimension(
                                                width,
                                                height,
                                                allowed_minimum_width,
                                                allowed_maximum_width,
                                                allowed_minimum_height,
                                                allowed_maximum_height,
                                            )) {
                                            $('.preview_image').attr('src', e.target.result);
                                            $('.error-preview .display-error-text').html("");
                                        } else {
                                            $(".error-preview").removeClass('hidden');
                                            $('.error-preview .display-error-text').html(`Invalid image dimension. Please select other image.`);
                                            $('input[type="file"]').val('');
                                        }
                                    }
                                }
                            }
                            reader.readAsDataURL(actual_file);

                            $(".error-preview").addClass('hidden');
                        } else {
                            $(".error-preview").removeClass('hidden');
                            $('.error-preview .display-error-text').html("File size exceeded. Upto " + (allowed_image_size / 1000) + " MB only!");
                            $('input[type="file"]').val('');
                        }
                    } else {
                        $(".error-preview").removeClass('hidden');
                        $('.error-preview .display-error-text').html("Invalid file format! Please select an image with a valid format.");
                        $('input[type="file"]').val('');
                        appService.SYSTEM.getOfficialLogo();
                    }
                } else {
                    $(".error-preview").addClass('hidden');
                    appService.SYSTEM.getOfficialLogo();
                }
            },

            resetImage: () => {
                appService.SYSTEM.getOfficialLogo();
                $('input[type="file"]').val('');
            },

            isValidImageDimension: (width, height, allowed_minimum_width, allowed_maximum_width, allowed_minimum_height, allowed_maximum_height) => {
                return ((width <= height) &&
                    (width >= allowed_minimum_width && width <= allowed_maximum_width) &&
                    (height >= allowed_minimum_height && height <= allowed_maximum_height));
            }
        },

        /**
         * Number related helper functions
         */
        NUMBER: {
            /**
             * Display number based on the specified number format
             * @return {String}
             */
            numberFormat: (number, decimals, decPoint, thousandsSep) => {

                number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
                var n = !isFinite(+number) ? 0 : +number
                var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
                var sep = (typeof thousandsSep === 'undefined') ? ',' : thousandsSep
                var dec = (typeof decPoint === 'undefined') ? '.' : decPoint
                var s = ''

                var toFixedFix = function (n, prec) {
                    var k = Math.pow(10, prec)
                    return '' + (Math.round(n * k) / k)
                        .toFixed(prec)
                }

                // @todo: for IE parseFloat(0.55).toFixed(0) = 0;
                s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.')
                if (s[0].length > 3) {
                    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
                }

                if ((s[1] || '').length < prec) {
                    s[1] = s[1] || ''
                    s[1] += new Array(prec - s[1].length + 1).join('0')
                }

                return s.join(dec)
            },
        },

        /**
         * Current user related helper functions
         */
        USER: {
            /**
             * Display the complete fullname of a person
             * @return {String}
             */
            getPersonFullname: (person) => {

                if (person && person.first_name && person.middle_name && person.last_name) {
                    var fname = new String(person.first_name),
                        mname = new String(person.middle_name),
                        lname = new String(person.last_name);

                    return `${fname} ${mname.substr(0, 1).toUpperCase()}. ${lname}`
                } else {
                    return "";
                }

            },

            getAccountID: (account) => {
                return account.type == 'teacher' ? account.faculty_id : account.student_id;
            },

            getCurrentAccountProfilePic: () => {

                $http.get('/helper/get_current_account_profile_pic').then((res) => {

                    var main_uri = '';

                    switch (res.data.account.type) {
                        case 'admin':
                            main_uri = appService.IMAGE_FILE.getFileSrc().admin;
                            break;
                        case 'teacher':
                            main_uri = appService.IMAGE_FILE.getFileSrc().faculty;
                            break;
                        case 'student':
                            main_uri = appService.IMAGE_FILE.getFileSrc().students;
                            break;
                    }

                    if (res.data.account.image) {
                        var image = main_uri + res.data.account.image;
                        $('.profile_pic').attr('src', image);
                    } else {
                        $('.profile_pic').attr('src', appService.IMAGE_FILE.defaultUserImage);
                    }
                });
            },

            getCurrentAccount: () => {
                return $http.get('/helper/get_current_account');
            },

            getCurrentUserInfo: (account_id) => {
                return $http.post('/helper/get_current_user_info', {
                    account_id
                });
            },
        },

        DATATABLE: {
            initializeDataTable: (params, settings) => {
                return new NgTableParams(params, settings);
            }
        },

        CHAT_HELPER: {

            registerLastViewedChat: (class_id) => {
                return $http.post(`/helper/register_last_viewed_chat`, {
                    class_id
                });
            },

            updateLastViewedChat: (class_id) => {
                return $http.post(`/helper/update_last_viewed_chat`, {
                    class_id
                });
            },

            monitorNewMessages: (message_count, class_id) => {
                return $http.post(`/helper/monitor_new_message`, {
                    message_count,
                    class_id
                });
            },

            getNewMessages: (class_id, chat_id) => {
                return $http.post(`/helper/get_new_messages`, {
                    class_id,
                    chat_id
                });
            },

            getNewMessagesCount: (class_id) => {
                return $http.post(`/helper/get_new_messages_count`, {
                    class_id
                });
            }
        },

        ACTIVITY_LOG_HELPER: {

            registerActivity: (activityDescription) => {
                return $http.post('/helper/register_activity', {
                    activityDescription
                }).then(res => {
                    return res.data.status;
                }, (err) => {
                    return false;
                });
            },

            getActivities: (activity_from, activity_to) => {
                return $http.post(`/helper/get_activities`, {
                    activity_from,
                    activity_to
                }).then(res => {
                    return {
                        activities: res.data.activities,
                        absoluteCount: res.data.absoluteCount
                    };
                }, (err) => {
                    return {
                        activities: [],
                        absoluteCount: 0
                    };
                });
            },

            clearAllActivities: () => {
                return $http.delete(`/helper/clear_activities`).then(res => {
                    return res.data.status;
                });
            }
        },

        NOTIFICATION_HELPER: {

            registerNotification: (notificationObj) => {
                return $http.post('/helper/register_notification', {
                    notify_to: notificationObj.notify_to,
                    notify_to_user_type: notificationObj.notify_to_user_type,
                    path: notificationObj.path,
                    description: notificationObj.description
                }).then(result => {
                    return result.data.status;
                });
            },

            registerSendUnsendHomeworkNotification: (notificationObj) => {
                return $http.post('/helper/register_send_unsend_homework_notification', {
                    class_id: notificationObj.class_id,
                    path: notificationObj.path,
                    description: notificationObj.description
                }).then(result => {
                    return result.data.status;
                });
            },
            
            registerApprovedDisapprovedHomeworkNotification: (notificationObj) => {
                return $http.post('/helper/register_approved_disapproved_homework_notification', {
                    homework_id: notificationObj.homework_id,
                    path: notificationObj.path,
                    description: notificationObj.description
                }).then(result => {
                    return result.data.status;
                });
            },

            readNotification: (notification_id) => {
                return $http.post('/helper/read_notifications', {
                    notification_id
                }).then(result => {
                    return result.data.status;
                });
            },

            getNotifcations: (notification_from, notification_to) => {
                return $http.post('/helper/get_notifications', {
                    notification_from,
                    notification_to
                }).then(result => {
                    return {
                        notifications: result.data.notifications,
                        absoluteCount: result.data.absoluteCount,
                        unreadNotificationsCount: result.data.unreadNotificationsCount
                    };
                });
            },

            clearNotifications: () => {
                return $http.delete('/helper/clear_notifications').then(result => {
                    return result.data.status;
                });
            },

            monitorNewNotifications: (absoluteCount) => {
                return $http.post('/helper/monitor_new_notifications', { absoluteCount }).then(result => {
                    return result.data.status;
                });
            },

            notificationPaths: {
                teacherClass: (classId) => {
                    return `/teacher/subject/${classId}/posts`;
                },

                teacherHome: () => {
                    return `/teacher`;
                },

                studentClass: (classId) => {
                    return `/student/subject/${classId}/posts`;
                },

                studentHome: () => {
                    return `/student`;
                },

                studentHomework: (classId, homeworkId) => {
                    return `/student/subject/${classId}/homeworks/${homeworkId}`;
                },

                studentHomeworkHome: (classId) => {
                    return `/student/subject/${classId}/homeworks`;
                },

                teacherHomework: (clasId, homeworkId) => {
                    return `/teacher/subject/${clasId}/homeworks/${homeworkId}`;
                }
            }
        }
    };

    return appService;
}]);