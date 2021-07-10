<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// ========================== Administrator Modules =======================================\

Route::group(['prefix' => 'helper'], function() {
    Route::post('static_status', 'HelperController@static_status');
    Route::post('post_unpost_module', 'HelperController@post_unpost_module');
    Route::get('get_current_account_profile_pic','HelperController@get_current_account_profile_pic');
    Route::get('get_current_semester','HelperController@get_current_semester');
    Route::get('get_current_school_year','HelperController@get_current_school_year');
    Route::get('get_current_account', 'HelperController@get_current_account');
    Route::post('get_current_user_info', 'HelperController@get_current_user_info');
    Route::get('get_ics_details', 'HelperController@get_ics_details');
    Route::get('about_us', 'HelperController@get_ics_details');
    Route::get('get_official_logo', 'HelperController@get_official_logo');

    Route::post('register_last_viewed_chat', 'HelperController@register_last_viewed_chat');
    Route::post('update_last_viewed_chat', 'HelperController@update_last_viewed_chat');
    Route::post('monitor_new_message', 'HelperController@monitor_new_message');
    Route::post('get_new_messages', 'HelperController@get_new_messages');
    Route::post('get_new_messages_count', 'HelperController@get_new_messages_count');

    Route::post('register_activity', 'HelperController@register_activity');
    Route::post('get_activities', 'HelperController@get_activities');
    Route::delete('clear_activities', 'HelperController@clear_activities');
    
    Route::post('register_notification', 'HelperController@register_notification');
    Route::post('read_notifications', 'HelperController@read_notifications');
    Route::delete('clear_notifications', 'HelperController@clear_notifications');
    Route::post('get_notifications', 'HelperController@get_notifications');
    Route::post('monitor_new_notifications', 'HelperController@monitor_new_notifications');
    Route::post('register_send_unsend_homework_notification', 'HelperController@register_send_unsend_homework_notification');
    Route::post('register_approved_disapproved_homework_notification', 'HelperController@register_approved_disapproved_homework_notification');
});

Route::group(['prefix' => 'access/'], function() {
    Route::get('','AccessController@index');
    Route::get('register','AccessController@render_register');
    Route::post('authenticate','AccessController@authenticate');
    Route::get('get_account_details', 'AccessController@get_details');
    Route::any('sign_out','AccessController@sign_out');
    Route::post('save_new_account', 'AccessController@save_new_account');
    Route::post('verify_student_id_exists', 'AccessController@verify_student_id_exists');
});

Route::group(['prefix' => 'admin', 'middleware' => 'authAccount'], function() {

    Route::get('', 'AdminDashboardController@render_dashboard');

    // -------------------- Manage Profile ----------------------------------

    Route::group(['prefix' => 'profile'], function() {
        Route::get('','AdminProfileController@render_profile');
        Route::get('/personal_information','AdminProfileController@render_personal_information');
        Route::get('/account_information','AdminProfileController@render_account_information');
        Route::get('/profile_picture','AdminProfileController@render_profile_picture');
        Route::get('/get_admin_profile','AdminProfileController@get_admin_profile');
        Route::post('/save_update_logo', 'AdminProfileController@save_update_logo');
        Route::put('/save_update_personal_info', 'AdminProfileController@save_update_personal_info');
        Route::put('/save_update_account_info', 'AdminProfileController@save_update_account_info');
    });

    Route::group(['prefix' => 'accounts_approval'], function() {
       Route::post('list_of_accounts_approval','AdminAccountApprovalController@list_of_accounts_approval');
       Route::get('','AdminAccountApprovalController@render_accounts_approval');
       Route::put('approve_account','AdminAccountApprovalController@approve_account');
    });
    // --------------------- Manage Settings --------------------------------

    Route::group(['prefix' => 'settings'], function() {
        Route::get('','AdminSettingsController@render_settings');    
        Route::get('/set_semester','AdminSettingsController@render_semester');    
        Route::get('/set_school_year','AdminSettingsController@render_school_year');    
        Route::get('/set_curriculum','AdminSettingsController@render_curriculum');    
    });

    // --------------------- Manage ICS Details -------------------------------

    Route::group(['prefix' => 'ics_details'], function() {
        Route::get('', 'AdminICSDetailsController@render_ics_details');
        Route::get('get_details', 'AdminICSDetailsController@get_details');
        Route::post('save_new_details', 'AdminICSDetailsController@save_new_details');
        Route::get('official_logo', 'AdminICSDetailsController@get_official_logo');
        Route::post('save_new_logo', 'AdminICSDetailsController@save_new_logo');
    });;
    
    // --------------------- Manage Announcements ----------------------------

    Route::group(['prefix' => 'announcements'], function() {
        Route::get('', 'AdminAnnouncementController@render_announcements');
        Route::get('get_announcements', 'AdminAnnouncementController@get_announcements');
        Route::get('add_announcement','AdminAnnouncementController@render_add_announcement');
        Route::get('edit_announcement/{id}','AdminAnnouncementController@render_edit_announcement');
        Route::post('save_new_announcement', 'AdminAnnouncementController@save_new_announcement');
        Route::post('get_current_announcement', 'AdminAnnouncementController@get_current_announcement');
        Route::post('save_update_announcement', 'AdminAnnouncementController@save_update_announcement');
        Route::delete('{id}', 'AdminAnnouncementController@remove_announcement');
    });
    

    // ---------------------- Manage Events ----------------------------------

    Route::group(['prefix' => 'events'], function() {
        Route::get('','AdminEventController@render_events');
        Route::get('edit_event/{id}','AdminEventController@render_edit_event');
        Route::get('get_events','AdminEventController@get_events');
        Route::post('save_new_event','AdminEventController@save_new_event');
        Route::delete('{id}','AdminEventController@remove_event');
        Route::get('{id}','AdminEventController@get_event');
        Route::put('save_update_event','AdminEventController@save_update_event');

    });


    // ------------------------ Manage Students -------------------------------

    Route::group(['prefix' => 'students'], function() {
        Route::get('','AdminStudentController@render_students');
        Route::get('add_student','AdminStudentController@render_add_student');
        Route::get('{id}','AdminStudentController@render_view_student');
        Route::get('edit_student/{id}','AdminStudentController@render_edit_student');
        Route::post('save_new_student','AdminStudentController@save_new_student');
        Route::post('get_students','AdminStudentController@get_students');
        Route::post('get_current_student','AdminStudentController@get_current_student');
        Route::post('get_students_subjects','AdminStudentController@get_students_subjects');
        Route::post('save_update_student','AdminStudentController@save_update_student');
        Route::delete('{id}','AdminStudentController@remove_student');
        Route::post('deactivate_student','AdminStudentController@deactivate_student');
        Route::post('activate_student','AdminStudentController@activate_student');
        Route::post('verify_student_id_exists','AdminStudentController@verify_student_id_exists');
    });


    // -------------------------- Manage Faculty -----------------------------

    Route::group(['prefix' => 'faculty'], function() {
        Route::get('', 'AdminFacultyController@render_faculty');
        Route::get('add_faculty', 'AdminFacultyController@render_add_faculty');
        Route::get('{id}', 'AdminFacultyController@render_view_faculty');
        Route::get('edit_faculty/{id}','AdminFacultyController@render_edit_faculty');
        Route::post('save_new_faculty','AdminFacultyController@save_new_faculty');
        Route::post('get_faculty','AdminFacultyController@get_faculty');
        Route::post('get_current_faculty','AdminFacultyController@get_current_faculty');
        Route::post('save_update_faculty', 'AdminFacultyController@save_update_faculty');
        Route::post('activate_faculty', 'AdminFacultyController@activate_faculty');
        Route::post('deactivate_faculty', 'AdminFacultyController@deactivate_faculty');
        Route::post('verify_teacher_id_exists', 'AdminFacultyController@verify_teacher_id_exists');
    });
    
    // --------------------------- Manage Faculty Loadings ---------------------

    Route::group(['prefix' => 'load'], function() {
        Route::get('', 'AdminLoadController@render_load');
        Route::post('get_faculty_subjects', 'AdminLoadController@get_faculty_subjects');
        Route::post('save_new_faculty_subject','AdminLoadController@save_new_faculty_subject');
        Route::post('save_update_faculty_subject','AdminLoadController@save_update_faculty_subject');
        Route::delete('{id}','AdminLoadController@remove_faculty_subject');
        Route::get('get_sections', 'AdminLoadController@get_sections');
        Route::post('verify_if_subject_exist_from_other_faculty', 'AdminLoadController@verify_if_subject_exist_from_other_faculty');
    });


    // --------------------------- Manage Subjects -----------------------------

    Route::group(['prefix' => 'subjects'], function() {
        Route::get('', 'AdminSubjectController@render_subjects');
        Route::get('edit_subject/{id}','AdminSubjectController@render_edit_subject');
        Route::post('save_new_subject','AdminSubjectController@save_new_subject');
        Route::get('get_subjects','AdminSubjectController@get_subjects');
        Route::delete('{id}','AdminSubjectController@remove_subject');
        Route::get('{id}','AdminSubjectController@get_current_subject');
        Route::post('save_update_subject','AdminSubjectController@save_update_subject');
        Route::post('verify_subject_loaded','AdminSubjectController@verify_subject_loaded');
    });
    

    // ---------------------------- Manage Messages ----------------------------

    Route::group(['prefix' => 'messages'], function() {
        Route::get('/inbox', 'AdminMessageController@render_inbox');
        Route::get('/sent', 'AdminMessageController@render_sent');
        Route::get('compose', 'AdminMessageController@render_compose');
        Route::get('get_sent_items','AdminMessageController@get_sent_items');
        Route::delete('remove_sent_item/{id}','AdminMessageController@remove_sent_item');
        Route::get('{id}','AdminMessageController@render_read_message');
        Route::get('/reply/{id}','AdminMessageController@render_reply_message');
        Route::get('/sent/{id}','AdminMessageController@render_sent_message');
        Route::post('send_message', 'AdminMessageController@send_message');
        Route::post('get_inbox_messages','AdminMessageController@get_inbox_messages');
        Route::post('get_sender_info','AdminMessageController@get_sender_info');
        Route::get('get_current_message/{id}','AdminMessageController@get_current_message');
        Route::post('send_reply_message','AdminMessageController@send_reply_message');
        Route::delete('remove_message/{id}','AdminMessageController@remove_message');
        Route::get('get_current_sent_item/{id}','AdminMessageController@get_current_sent_item');
        Route::post('forward_message','AdminMessageController@forward_message');
    });
    
    /// ---------------------------- Manage Courses -----------------------------
    Route::group(['prefix' => 'courses'], function() {
         Route::get('', 'AdminCourseController@render_courses');
         Route::post('save_new_course', 'AdminCourseController@save_new_course');
         Route::get('get_courses', 'AdminCourseController@get_courses');
         Route::put('save_update_course', 'AdminCourseController@save_update_course');
         Route::delete('{id}', 'AdminCourseController@delete_course');
         Route::post('verify_designated_course', 'AdminCourseController@verify_designated_course');
    });
   

   // ------------------------------- Manage Curriculum -------------------------
    //admin/curriculum
   Route::group(['prefix' => 'curriculum'], function() {
        Route::get('', 'AdminCurriculumController@render_curriculum');
        Route::post('get_curriculum_subjects', 'AdminCurriculumController@get_curriculum_subjects');
        Route::post('save_curriculum_subjects','AdminCurriculumController@save_curriculum_subjects');
        Route::get('get_curriculum_school_years','AdminCurriculumController@get_curriculum_school_years');
        Route::delete('{id}','AdminCurriculumController@remove_curriculum_subject');
        Route::post('verify_subject_exists','AdminCurriculumController@verify_subject_exists');
        Route::post('verify_subject_exists_in_loads','AdminCurriculumController@verify_subject_exists_in_loads');
        Route::get('get_curriculum_years','AdminCurriculumController@get_curriculum_years');
        Route::get('get_curriculum_year_levels','AdminCurriculumController@get_curriculum_year_levels');
        Route::get('print_curriculum_page/{course_description}/{course}/{curriculum_year}','AdminCurriculumController@print_curriculum_page');
   });

   // -------------------------------- Manage School Year -----------------------

   Route::group(['prefix' => 'school_year'], function() {
       Route::get('get_current_school_year', 'AdminSchoolYearController@get_current_school_year');
       Route::post('save_new_school_year', 'AdminSchoolYearController@save_new_school_year');
       Route::get('get_school_year', 'AdminSchoolYearController@get_school_year');
       Route::delete('{id}', 'AdminSchoolYearController@remove_school_year');
       Route::put('save_update_school_year', 'AdminSchoolYearController@save_update_school_year');
       Route::post('set_new_school_year', 'AdminSchoolYearController@set_new_school_year');
       Route::post('validate_used_school_year', 'AdminSchoolYearController@validate_used_school_year');
   });

   //-------------------------------- Manage Semester --------------------------------

   Route::group(['prefix' => 'semester'], function() {
       Route::get('get_semesters', 'AdminSemesterController@get_semesters');
       Route::get('get_current_semester', 'AdminSemesterController@get_current_semester');
       Route::put('save_update_current_semester', 'AdminSemesterController@save_update_current_semester');
       Route::post('save_new_semester','AdminSemesterController@save_new_semester');
       Route::delete('{id}','AdminSemesterController@remove_semester');
       Route::put('save_update_semester','AdminSemesterController@save_update_semester');
       Route::post('validate_assigned_semested','AdminSemesterController@validate_assigned_semested');
   });

   // -------------------------------- Manage Classes ---------------------------
   
   Route::group(['prefix' => 'classes'], function() {
       Route::get('', 'AdminClassController@render_classes');
       Route::post('set_class_details', 'AdminClassController@set_class_details');
       Route::get('{id}', 'AdminClassController@get_official_class_list');
       Route::post('add_student_class', 'AdminClassController@add_student_class');
       Route::delete('{id}', 'AdminClassController@remove_student_class');
       Route::post('get_sections', 'AdminClassController@get_sections');
   });
});


Route::group(['prefix' => 'teacher', 'middleware' => 'authAccount'], function() {

    Route::group(['prefix' => 'navbar'], function() {
        Route::get('get_faculty_subjects','TeacherNavbarController@get_faculty_subjects');
        Route::get('get_number_of_subjects','TeacherNavbarController@get_number_of_subjects');
    });

    Route::group(['prefix' => 'subjects_approval'], function() {
        Route::get('get_subjects_approval','TeacherSubjectApprovalController@get_subjects_approval');
        Route::get('','TeacherSubjectApprovalController@render_subjects_approval');
        Route::post('approve_subject','TeacherSubjectApprovalController@approve_subject');
        
    });
    Route::get('','TeacherDashboardController@render_dashboard');
    
    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('get_faculty_subjects','TeacherDashboardController@get_faculty_subjects');
    });

    Route::group(['prefix' => 'chat'], function() {
        Route::get('', 'TeacherChatController@render_chat');
        Route::get('get_faculty_subjects','TeacherChatController@get_faculty_subjects');
        Route::post('get_conversation','TeacherChatController@get_conversation');
        Route::post('send_chat','TeacherChatController@send_chat');
        Route::post('monitor_new_message','TeacherChatController@monitor_new_message');
        Route::post('monitor_other_subject_new_message','TeacherChatController@monitor_other_subject_new_message');
        Route::get('get_total_number_messages','TeacherChatController@get_total_number_messages');
        Route::delete('{id}','TeacherChatController@clear_all_conversations');
    });
    

    Route::group(['prefix' => 'profile'], function() {
        Route::get('', 'TeacherProfileController@render_profile');
        Route::get('personal_information', 'TeacherProfileController@render_personal_information');
        Route::get('account_information', 'TeacherProfileController@render_account_information');
        Route::get('profile_picture', 'TeacherProfileController@render_profile_picture');

        Route::get('get_teacher_profile','TeacherProfileController@get_teacher_profile');
        Route::post('save_update_logo','TeacherProfileController@save_update_logo');
        Route::put('save_update_personal_info', 'TeacherProfileController@save_update_personal_info');
        Route::put('save_update_account_info', 'TeacherProfileController@save_update_account_info');
        
    });
    
    Route::group(['prefix' => 'messages'], function() {
        Route::get('inbox','TeacherMessageController@render_inbox');
        Route::get('sent','TeacherMessageController@render_sent');
        Route::get('compose','TeacherMessageController@render_compose');
        Route::get('{id}','TeacherMessageController@render_view_message');
        Route::get('reply/{id}','TeacherMessageController@render_reply_message');
        Route::get('sent/{id}','TeacherMessageController@render_sent_message');
    });

    Route::group(['prefix' => 'subject/{id}'], function() {
        // =============== Manage Posts ====================
        Route::group(['prefix' => 'posts'], function() {
            Route::get('', 'TeacherPostController@index');
            Route::get('add_post', 'TeacherPostController@render_add_post');
            Route::get('edit_post/{post_id}', 'TeacherPostController@render_edit_post');
        });
        
        

        // =============== Manage Class List ==================== 
        Route::group(['prefix' => 'class'], function() {
            Route::get('', 'TeacherClassController@index');
            Route::get('enroll_students', 'TeacherClassController@render_enroll_students');
        });   
       

        // =============== Manage Homeworks ====================
        Route::group(['prefix' => 'homeworks'], function() {
            Route::get('','TeacherHomeworkController@render_homeworks');
            Route::get('add_homework', 'TeacherHomeworkController@render_add_homework');
            Route::get('{homework_id}', 'TeacherHomeworkController@render_view_homework');
            Route::get('edit_homework/{homework_id}', 'TeacherHomeworkController@render_edit_homework');
            
        });
    });
});


Route::group(['prefix' => 'student', 'middleware' => 'authAccount'], function() {

    Route::group(['prefix' => 'navbar'], function() {
        Route::get('get_student_subjects','StudentNavbarController@get_student_subjects');
        Route::get('get_number_of_subjects','StudentNavbarController@get_number_of_subjects');
    });

    Route::group(['prefix' => 'enroll_subjects'], function() {
        Route::get('','StudentEnrollSubjectsController@render_enroll_subjects');
        Route::get('get_subjects/{course}/{yearLevel}','StudentEnrollSubjectsController@get_subjects');
        Route::post('enroll_subject','StudentEnrollSubjectsController@enroll_subject');
        Route::post('unenroll_subject','StudentEnrollSubjectsController@unenroll_subject');
        Route::get('get_curriculum_year_levels','StudentEnrollSubjectsController@get_curriculum_year_levels');
        Route::get('get_courses','StudentEnrollSubjectsController@get_courses');
    });
    Route::get('','StudentDashboardController@render_dashboard');

    Route::group(['prefix' => 'dashboard'], function() {
        Route::get('get_student_subjects','StudentDashboardController@get_student_subjects');
    });

    Route::group(['prefix' => 'chat'], function() {
        Route::get('', 'StudentChatController@render_chat');
        Route::get('get_student_subjects','StudentChatController@get_student_subjects');
        Route::post('get_conversation','StudentChatController@get_conversation');
        Route::post('send_chat','StudentChatController@send_chat');
        Route::post('monitor_new_message','StudentChatController@monitor_new_message');
        Route::post('monitor_other_subject_new_message','StudentChatController@monitor_other_subject_new_message');
        Route::get('get_total_number_messages','StudentChatController@get_total_number_messages');
    });

    Route::group(['prefix' => 'messages'], function() {
        Route::get('inbox', 'StudentMessageController@render_inbox');
        Route::get('sent', 'StudentMessageController@render_sent');
        Route::get('compose', 'StudentMessageController@render_compose');
        Route::get('{id}','StudentMessageController@render_read_message');
        Route::get('reply/{id}','StudentMessageController@render_reply_message');
        Route::get('sent/{id}','StudentMessageController@render_sent_message');
    });

    Route::group(['prefix' => 'profile'], function() {
        Route::get('', 'StudentProfileController@render_profile');
        Route::get('personal_information','StudentProfileController@render_personal_information');
        Route::get('account_information','StudentProfileController@render_account_information');
        Route::get('profile_picture','StudentProfileController@render_profile_picture');

        Route::get('get_student_profile','StudentProfileController@get_student_profile');
        Route::post('save_update_logo','StudentProfileController@save_update_logo');
        Route::put('save_update_personal_info', 'StudentProfileController@save_update_personal_info');
        Route::put('save_update_account_info', 'StudentProfileController@save_update_account_info');

    });

    Route::group(['prefix' => 'subject/{id}'], function() {
        Route::group(['prefix' => 'posts'], function() {
            Route::get('', 'StudentPostController@index');
            Route::get('add_post', 'StudentPostController@render_add_post');
            Route::get('edit_post/{post_id}', 'StudentPostController@render_edit_post');
        });

        Route::resource('class', 'StudentClassController');

        Route::group(['prefix' => 'homeworks'], function() {
            Route::get('', 'StudentHomeworksController@render_homeworks');
            Route::get('{homework_id}', 'StudentHomeworksController@render_view_homework');
        });
    });    
});

Route::group(['prefix' => 'chat'], function() {
    Route::post('get_conversation','AccountChatController@get_conversation');
    Route::post('send_chat','AccountChatController@send_chat');
    Route::post('monitor_new_message','AccountChatController@monitor_new_message');
    Route::post('monitor_other_subject_new_message','AccountChatController@monitor_other_subject_new_message');
    Route::get('get_total_number_messages','AccountChatController@get_total_number_messages');
});

Route::group(['prefix' => 'posts'], function() {
    Route::post('save_new_post', 'AccountPostController@save_new_post');
    Route::post('get_posts', 'AccountPostController@get_posts');
    Route::delete('{id}','AccountPostController@remove_post');
    Route::post('get_post_details', 'AccountPostController@get_post_details');
    Route::post('get_comments','AccountPostController@get_comments');
    Route::put('save_update_post','AccountPostController@save_update_post');

});

Route::group(['prefix' => 'comments'], function() {
    Route::post('send_new_comment', 'AccountCommentController@send_new_comment');
    Route::put('save_edit_comment', 'AccountCommentController@save_edit_comment');
    Route::delete('{id}', 'AccountCommentController@remove_comment');
});

Route::group(['prefix' => 'classes'], function() {
    Route::post('get_class_list','AccountClassController@get_class_list');
    Route::post('get_student_list','AccountClassController@get_student_list');
    Route::delete('{id}','AccountClassController@remove_student');
    Route::post('enroll_student','AccountClassController@enroll_student');
    Route::post('unenroll_student','AccountClassController@unenroll_student');
});

Route::group(['prefix' => 'homeworks'], function() {
    Route::post('get_homeworks','AccountHomeworksController@get_homeworks');
    Route::post('save_new_homework','AccountHomeworksController@save_new_homework');
    Route::post('upload_homework_file','AccountHomeworksController@upload_homework_file');
    Route::put('send_homework','AccountHomeworksController@send_homework');
    Route::put('unsend_homework','AccountHomeworksController@unsend_homework');
    Route::delete('{id}','AccountHomeworksController@remove_homework');
    Route::post('get_homework_details','AccountHomeworksController@get_homework_details');
    Route::put('save_update_homework','AccountHomeworksController@save_update_homework');
    Route::post('get_submitted_homeworks','AccountHomeworksController@get_submitted_homeworks');
    Route::put('approved_homework','AccountHomeworksController@approved_homework');
    Route::post('get_student_homeworks','AccountHomeworksController@get_student_homeworks');
    Route::post('submit_file','AccountHomeworksController@submit_file');
});

Route::get('/','HomeController@index');

Route::group(['prefix' => 'announcements'], function(){
   Route::get('get_latest_announcments', 'HomeAnnouncementController@get_latest_announcments');
});

Route::group(['prefix' => 'about_us'], function() {
    Route::get('','HomeAboutUsController@render_about_us');
});

Route::group(['prefix' => 'announcements'], function() {
    Route::get('','HomeAnnouncementController@render_announcements');
    Route::get('get_all_announcements','HomeAnnouncementController@get_all_announcements');
    Route::get('{id}','HomeAnnouncementController@render_read_announcement');
    Route::post('get_announcement_details','HomeAnnouncementController@get_announcement_details');
});

Route::group(['prefix' => 'events'], function() {

    Route::get('', 'HomeEventController@render_events');
    Route::get('get_latest_events', 'HomeEventController@get_latest_events');
    Route::get('get_all_events', 'HomeEventController@get_all_events');
});