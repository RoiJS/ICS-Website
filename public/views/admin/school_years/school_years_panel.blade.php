<!-- #start Manage School Year Section -->
<script type="text/javascript" src="/js/services/admin/admin.school.year.service.js"></script>
<script type="text/javascript" src="/js/controllers/admin/admin.school.year.controller.js"></script>

<div class="panel box box-success" ng-controller="adminSchoolYearController">
    <div class="box-header with-border">
        <h4 class="box-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
            <i class="fa fa-calendar"></i> School Year
        </a>
        </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse in" >
        @include('admin.school_years.partials.school_year_list_panel')

        @include('admin.school_years.partials.create_school_year_form_panel')
    </div>
</div>
<!-- #end -->