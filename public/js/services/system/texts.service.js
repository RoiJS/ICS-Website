app.factory('textsService', [() => {

    var APP_TEXTS =  {
        
         // ************************** System ***********************************
        SYSTEM: {
            TXT_NOTE: 'NOTE',
            TXT_REQUIRED_FIELDS: 'Required Fields.'
        },

        // ************************** Subjects ***********************************
        SUBJECT : {
            ENTER_MISSING_SUBJECT_CODE: 'Please enter subject code',
            ENTER_MISSING_SUBJECT_DESCRIPTION: 'Please enter subject description',
            ENTER_MISSING_SUBJECT_LEC_UNIT: 'Empty lec unit',
            ENTER_MISSING_SUBJECT_LAB_UNIT: 'Empty lec unit',
            REMOVE_SUBJECT_DIALOG_TITLE: 'Remove subject',
            REMOVE_SUBJECT_DIALOG_MESSAGE: 'Are you sure to remove selected subject information?',
            REMOVE_SUBJECT_SUCCESS: 'Selected subject has been successfully removed.',

            REMOVE_SUBJECT_FAILED_DIALOG_TITLE: 'Remove failed',
            REMOVE_SUBJECT_FAILED_DIALOG_MESSAGE: 'Failed to remove selected subject. Please try it again later.',
            
            SAVE_NEW_SUBJECT_DIALOG_TITLE: 'Save new subject',
            SAVE_NEW_SUBJECT_DIALOG_MESSAGE: 'Are you sure to save new subject information?',
            SAVE_NEW_SUBJECT_SUCCESS: 'New subject has been successfully saved.',
            SAVE_NEW_SUBJECT_FAILED_DIALOG_TITLE: 'Save failed',
            SAVE_NEW_SUBJECT_FAILED_DIALOG_MESSAGE: 'Failed to save new subject information. Please try it again later.',
            DUPLICATE_SUBJECT_CODE_DIALOG_TITLE: 'Subject code exists',
            DUPLICATE_SUBJECT_CODE_DIALOG_MESSAGE: 'Subject code already been used. Please enter other subject code.',
            INCOMPLETE_SUBJECT_INFORMATION_DIALOG_TITLE: 'Incomplete information',
            INCOMPLETE_SUBJECT_INFORMATION_DIALOG_MESSAGE: 'Please fill in all required information in order to create new subject.',
            
            FORM_CODE_CONTROL_FIELD: 'Code',
            FORM_DESC_CONTROL_FIELD: 'Description',
            FORM_LEC_UNIT_CONTROL_FIELD: 'Lec units',
            FORM_LAB_UNIT_CONTROL_FIELD: 'Lab units',

            TABLE_SUBJECT_LIST: 'Subjects',
            COLUMN_CODE: "'Code'",
            COLUMN_DESC: "'Description'",
            COLUMN_LEC_UNITS: "'Lec units'",
            COLUMN_LAB_UNITS: "'Lab units'",
            
            REMOVE_ENROLLED_SUBJECT_DIALOG_TITLE: 'Remove restricted',
            REMOVE_ENROLLED_SUBJECT_DIALOG_MESSAGE: 'Selected subject cannot be removed. Subject is designated to a class.',

        },

        COURSE: {

            SAVE_COURSE_DIALOG_TITLE: 'Save new course',
            SAVE_COURSE_DIALOG_MESSAGE: 'Are you sure to save new course?',

            SAVE_COURSE_SUCCESS_DIALOG_TITLE: 'New course has been successfully saved.',

            SAVE_COURSE_FAILED_DIALOG_TITLE: 'Save course failed',
            SAVE_COURSE_FAILED_DIALOG_MESSAGE: 'Failed to save new course. Please try again later.',
            
            UPDATE_COURSE_DIALOG_TITLE: 'Update course',
            UPDATE_COURSE_DIALOG_MESSAGE: 'Are you sure to update selected course?',

            UPDATE_COURSE_SUCCESS_DIALOG_MESSAGE: 'Selected course has been successfully updated',
            UPDATE_COURSE_FAILED_DIALOG_TITLE: 'Update course failed',
            UPDATE_COURSE_FAILED_DIALOG_MESSAGE: 'Failed to update course information. Please try again later.',

            REMOVE_COURSE_DIALOG_TITLE: 'Remove course',
            REMOVE_COURSE_DIALOG_MESSAGE: 'Are you sure to remove selected course?',
            REMOVE_COURSE_SUCCESS_DIALOG_TITLE: 'Selected course has been deleted',
            REMOVE_COURSE_FAILED_DIALOG_TITLE: 'Remove course failed',
            REMOVE_COURSE_FAILED_DIALOG_MESSAGE: 'Failed to remove selected course. Please try again later.',

            REMOVE_COURSE_RESTRICTED_DIALOG_TITLE: 'Delete couse restricted',
            REMOVE_COURSE_RESTRICTED_DIALOG_MESSAGE: 'Selected course cannot be deleted because it is being designated on load or curriculum module.',
            
            ENTER_MISSING_COURSE_NAME: 'Empty course name.',
        },

        SCHOOL_YEAR: {

            SAVE_SY_DIALOG_TITLE: 'Save school year',
            SAVE_SY_DIALOG_MESSAGE: 'Are you sure to save new school year?',

            SAVE_SY_SUCCESS_DIALOG_MESSAGE: 'New school year has been saved.',

            SAVE_SY_FAILED_DIALOG_TITLE: 'Save failed',
            SAVE_SY_FAILED_DIALOG_MESSAGE: 'Failed to save new school year. Please try it again later.',

            INVALID_SY_DIALOG_TITLE: 'Invalid school year',
            INVALID_SY_DIALOG_MESSAGE: 'Selected school year already exists. Please select different school year.',
        }
    } 

    return APP_TEXTS;
}]);
    