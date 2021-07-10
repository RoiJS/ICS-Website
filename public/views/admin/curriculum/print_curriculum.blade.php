<html ng-app="wmsu_ics_app">
    <head>
        <title>Print Curriculum</title>
        <script type="text/javascript" src="/js/angular.min.js"></script> 
        <script type="text/javascript" src="/js/main.app.js"></script>
        <script src="/assets/account/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <script src="/js/controllers/admin/admin.print.curriculum.controller.js"></script>

        <script type="text/javascript" src="/js/services/system/helper.service.js"></script>
	    <script type="text/javascript" src="/js/services/system/texts.service.js"></script>
        <script type="text/javascript" src="/js/directives/ng-table.directive.js"></script>
        <script type="text/javascript" src="/assets/shared/ui-calendar/angular-ui-calendar/src/calendar.js"></script>
        
        <link rel="stylesheet" href="/css/admin/curriculum.css">
    </head>
    <body ng-controller="adminPrintCurriculumController">

        <div class="curriculum-details-container">
            <div class="header-details">
                <span>Institute of Computer Studies</span><br>
                <span>{{$course_description}}</span><br>
                <span>{{$curriculum_year}}</span><br>
            </div>
            <div class="body-details">
                <div class="subject-list-details">

                    @foreach ($curriculum_subjects_list as $key => $value) 
                        <div class="year-level-subject-details">
                            <div class="subject-details-header">
                                <span>{{$key}}</span>
                            </div>
                            <div class="subject-details-body">
                                @foreach($value as $key1 => $value1)
                                    <div class="semester-subject">
                                        <div class="semester-header">
                                            <span>{{$key1}}</span>
                                        </div>
                                        <div class="semester-body">
                                            <div class="subject-list">
                                                <table>
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th></th>
                                                            <th>Lec (Hrs)</th>
                                                            <th>Lab (Hrs)</th>
                                                            <th>Unit</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach($value1['subjects'] as $subject)
                                                            <tr>
                                                                <td>{{$subject->subject_code}}</td>
                                                                <td>{{$subject->subject_description}}</td>
                                                                <td class="leclab-value">{{$subject->lec_units}}</td>
                                                                <td class="leclab-value">{{$subject->lab_units}}</td>
                                                                <td class="leclab-value">{{$subject->total_units}}</td>
                                                            </tr>
                                                        @endforeach
                                                        <tr>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="leclab-total-value">{{$value1['units_overall_total']}}</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    
                    <!-- <div class="year-level-subject-details">
                        <div class="subject-details-header">
                            <span>SECOND YEAR</span>
                        </div>
                        <div class="subject-details-body">
                            <div class="semester-subject">
                                <div class="semester-header">
                                    <span>FIRST SEMESTER</span>
                                </div>
                                <div class="semester-body">
                                    <div class="subject-list">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Lec (Hrs)</th>
                                                    <th>Lab (Hrs)</th>
                                                    <th>Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>CSST 111</td>
                                                    <td>Computer Programming 1</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>CSST 112</td>
                                                    <td>CS Fundamentals</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>CSST 113</td>
                                                    <td>Algebra</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>CSST 114</td>
                                                    <td>Chemistry 1</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="semester-subject">
                                <div class="semester-header">
                                    <span>SECOND SEMESTER</span>
                                </div>
                                <div class="semester-body">
                                    <div class="subject-list">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th></th>
                                                    <th>Lec (Hrs)</th>
                                                    <th>Lab (Hrs)</th>
                                                    <th>Unit</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>CSST 111</td>
                                                    <td>Computer Programming 1</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>CSST 112</td>
                                                    <td>CS Fundamentals</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>CSST 113</td>
                                                    <td>Algebra</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                                <tr>
                                                    <td>CSST 114</td>
                                                    <td>Chemistry 1</td>
                                                    <td>1</td>
                                                    <td>3</td>
                                                    <td>4</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </body>
</html>