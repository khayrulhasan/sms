<?php
$options = get_dashboard_options();
$total_student_present = total_student_present();
$total_student_absent  = 100 - total_student_present();
?>
<!--Footer-part-->
<div class="row-fluid">
  <div id="footer" class="span12">
    <?php echo ( isset( $options['dashboard_admin_footer_text'] ) ) ? $options['dashboard_admin_footer_text'] : '2016 &copy; Bangladesh Public School Admin. Brought to you by <a href="#">Bangladesh Public School Team</a>'; ?>
  </div>
</div>
<!--end-Footer-part-->

<script src="<?php echo base_url(); ?>public/backend/js/jquery.ui.custom.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/bootstrap-colorpicker.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/bootstrap-datepicker.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/jquery.toggle.buttons.html"></script>
<script src="<?php echo base_url(); ?>public/backend/js/masked.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/jquery.uniform.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/select2.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/elspress.tables.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/elspress.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/elspress.form_common.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/wysihtml5-0.3.0.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/jquery.flot.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/jquery.flot.pie.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/elspress.charts.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/jquery.peity.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/bootstrap-wysihtml5.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/c3.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/d3.v3.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url(); ?>public/backend/js/elspress.dashboard.js"></script>





<script>
	$('.textarea_editor').wysihtml5();

  // Attendance check date is selected
  function checkSetData(id)
  {
    $(id).css('border', '0 none');
    var v = $(id).val();
    if( v == '' ){
      alert('Select Date to Attendance !');
      $(id).css('border', '1px solid #f00');
      return false;
    }
    else{
      var selector = $(id).parent().parent().find('td.action a.action-link');
      var URL = selector.attr('href');
      URL += '/' + $(id).val();
      selector.attr('href', URL);
    }
  }

  // make attend
  $('.make_attendance').change(function(){
    var attendanceDate  = $(this).attr('attendance-date');
    var studentID       = $(this).attr('student-id');
    var classID         = $(this).attr('student-class');
    var url             = '<?php echo base_url('dashboard/attendance/make'); ?>';
    var present         = ( $(this).is(':checked') ) ? 1 : 0;
    // alert(present);
    // call Ajax
    $.ajax({
      mimeType: 'text/html; charset=utf-8', // ! Need set mimeType only when run from local file
      url: url,
      data: {
        attendanceDate  : attendanceDate,
        studentID       : studentID,
        classID         : classID,
        present         : present,
      },
      type: 'POST',
      success: function(data) {
        var result = $.parseJSON(data);
        if( result.success == 1 )
        {
          var t = ( present ) ? 'Present' : 'Absant';
          $.gritter.add({
            title:	'Attendance Status',
            text:	'Roll - ' + studentID + ' ' + t,
            sticky: false
          });
        }
        else {
          $.gritter.add({
            title:	'Attendance Status',
            text:	'Failed',
            sticky: false
          });
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        alert(errorThrown);
      },
      dataType: "html",
      async: false
    });

  });
</script>

<script>
  // attand PIE
  var chart = c3.generate({
    bindto: '#attandPieChart',
    data: {
      // iris data from R
      columns: [
          ['Present', <?php echo $total_student_present; ?>],
          ['Absant', <?php echo $total_student_absent; ?>],
      ],
      type : 'pie'
    }
  });

  // pass
  var chart = c3.generate({
    bindto: '#passDonutChart',
    data: {
      // iris data from R
      columns: [
          ['Passed', 85],
          ['Failed', 15],
      ],
      type : 'donut'
    }
  });

  // scoreChart grade
  var chart = c3.generate({
    bindto: '#scoreChart',
    data: {
      // iris data from R
      columns: [
          ['A+', 30],
          ['A', 40],
          ['A-', 15],
          ['B', 15],
      ],
      type : 'donut'
    },
  });
</script>

<span class="site_url" style="display:none;"><?php echo base_url(); ?></span>
</body>
</html>
