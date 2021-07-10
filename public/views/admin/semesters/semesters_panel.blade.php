<!-- #start Manage Semester Section -->
<script type="text/javascript" src="/js/services/admin/admin.semesters.service.js"></script>
<script type="text/javascript" src="/js/controllers/admin/admin.semesters.controller.js"></script>

<div class="panel box box-success" ng-controller="adminSemestersController">
    <div class="box-header with-border">
        <h4 class="box-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
            <i class="fa fa-graduation-cap"></i> Semester
        </a>
        </h4>
    </div>

    <!-- #start Section List Section -->
    <div id="collapseOne" class="panel-collapse collapse in">
        @include('admin.semesters.partials.semesters_list_panel')

        @include('admin.semesters.partials.create_semester_form_panel')
        
    </div>
    <!-- #end -->
</div>
<!-- #end -->