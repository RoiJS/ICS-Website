<!-- ******************************** Create New Subject Form *************************************** -->

<div id="create-subject-form-view" class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Create Subject</h3>
    </div>
    <form novalidate name="subjectForm" ng-model-options="{updateOn : 'submit'}" ng-submit="saveNewSubject()">
        <div class="box-body">
            <label class="lbl-note-message">@{{sysTxtsHelper.TXT_NOTE}} : (<span class="required-field">*</span>) @{{sysTxtsHelper.TXT_REQUIRED_FIELDS}}</label> <br>
            <div class="create-subject-panel">

                <div class="ctrl-section ctrl-code">
                    <div class="form-group">
                        <label for="subject_code">@{{subjTxtsHelper.FORM_CODE_CONTROL_FIELD}}: <span class="required-field">*</span></label>
                        <input type="text" ng-model="subject.subject_code" class="form-control" id="subject-code" placeholder="Enter subject code&hellip;">
                    </div>
                </div>

                <div class="ctrl-section ctrl-description">
                    <div class="form-group">
                        <label for="description">@{{subjTxtsHelper.FORM_DESC_CONTROL_FIELD}}: <span class="required-field">*</span></label>
                        <input type="text" ng-model="subject.subject_description" class="form-control" id="description" placeholder="Enter subject desciption&hellip;">
                    </div> 
                </div>

                <div class="ctrl-section ctrl-unit-section">
                   
                    <div class="ctrl-section ctrl-lec-unit">
                        <div class="form-group">
                            <label for="lec_unit">@{{subjTxtsHelper.FORM_LEC_UNIT_CONTROL_FIELD}}: <span class="required-field">*</span></label>
                            <input type="number" ng-model="subject.lec_unit" value="0" step="0.1" class="form-control" id="lec-unit">
                        </div>   
                    </div>

                    <div class="ctrl-section ctrl-lab-unit">
                        <div class="form-group">
                            <label for="lab_unit">@{{subjTxtsHelper.FORM_LAB_UNIT_CONTROL_FIELD}}: <span class="required-field">*</span></label>
                            <input type="number" ng-model="subject.lab_unit" value="0" step="0.1" class="form-control" id="lab-unit">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-footer">
            <div class="space"></div>
            <button type="submit" class="btn btn-success btn-save-subject"><i class="fa fa-save"></i> Save</button>
            <button type="button" ng-click="resetForm()" class="btn btn-warning btn-clear-subject"><i class="fa fa-eraser"></i> Clear</button>
        </div>
    </form>
</div>