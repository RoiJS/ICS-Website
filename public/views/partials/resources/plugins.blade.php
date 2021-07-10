<!-- <script>
  $.widget.bridge('uibutton', $.ui.button);
</script> -->

<script>
	$(".timepicker").timepicker({
		showInputs: false
	});
</script>

<!-- Bootstrap 3.3.6 -->
<script src="/assets/account/bootstrap/js/bootstrap.min.js"></script>

<!-- DataTables -->
<script src="/assets/account/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="/assets/account/plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- Sparkline -->
<script src="/assets/account/plugins/sparkline/jquery.sparkline.min.js"></script>

<!-- jvectormap -->
<script src="/assets/account/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="/assets/account/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>

<!-- jQuery Knob Chart -->
<script src="/assets/account/plugins/knob/jquery.knob.js"></script>

<!-- daterangepicker -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script> -->
<script src="/assets/account/plugins/daterangepicker/daterangepicker.js"></script>

<!-- datepicker -->
<script src="/assets/account/plugins/datepicker/bootstrap-datepicker.js"></script>

<!-- CK Editor -->
<script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>

<!-- Bootstrap WYSIHTML5 -->
<script src="/assets/account/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>

<!-- Slimscroll -->
<script src="/assets/account/plugins/slimScroll/jquery.slimscroll.min.js"></script>

<!-- FastClick -->
<script src="/assets/account/plugins/fastclick/fastclick.js"></script>

<!-- AdminLTE App -->
<script src="/assets/account/dist/js/app.min.js"></script>

<!-- bootstrap color picker -->
<script src="/assets/account/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

<!-- iCheck 1.0.1 -->
<script src="/assets/account/plugins/iCheck/icheck.min.js"></script>

<!-- Select2 -->
<script src="/assets/account/plugins/select2/select2.full.min.js"></script>

<!-- Zebra dialog -->
<script src="/css/zebra-dialog-master/zebra_dialog.min.js"></script>

<!-- InputMask -->
<script src="/assets/account/plugins/input-mask/jquery.inputmask.js"></script>
<script src="/assets/account/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="/assets/account/plugins/input-mask/jquery.inputmask.extensions.js"></script>
<script>
      $('#daterange-btn').daterangepicker(
        {
          ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          },
          startDate: moment().subtract(29, 'days'),
          endDate: moment()
        },
        function (start, end) {
          $('#daterange-btn span').html(start.format('MMM D, YYYY') + ' - ' + end.format('MMM D, YYYY'));
        }
      );

      $(".my-colorpicker2").colorpicker();
</script>

<script>
  $(function () {
    
    $("[data-mask]").inputmask();

    $(".curriculum-subjects-list").select2();
    $(".contact-list").select2();
    $(".select-model").select2();

    $('.school-year-container').slimScroll({height : "260px"});
    $('.semester-container').slimScroll({height : "170px"});
    $('.curriculum-subjects-container').slimScroll({height : "200px"});
    $('.loan-subjects-container').slimScroll({height : "300px"});
    $('.subject-list-container').slimScroll({height : "70vh"});
    $('.class-list-container').slimScroll({height : "300px"});
    // $('.notificationas-container').slimScroll({height : "350px"});
    // $('.recent-activities-container').slimScroll({height : "350px"});
    $('.group-chat-container').slimScroll({height : "400px"});
    
    $('.homeworks-file-upload-container').slimScroll({height : "300px"});
    $('.text-editor-container').slimScroll({height : "295px"});
    $('.text-editor-container-post').slimScroll({height : "250px"});
    $('.homework-editor-container').slimScroll({height : "150px"});

    //bootstrap WYSIHTML5 - text editor
    $(".textarea").wysihtml5();
    //Add text editor
    $("#compose-textarea").wysihtml5();

    //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    });

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-green',
      radioClass: 'iradio_minimal-green'
    });
    
  });
</script>