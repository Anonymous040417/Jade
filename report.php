<?php
require_once 'includes/header.php';

// Show PHP errors if any
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<!-- jQuery + jQuery UI (for Datepicker) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/smoothness/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>

<!-- Bootstrap 3 already assumed to be included via header.php -->

<div class="row">
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
        <i class="glyphicon glyphicon-check"></i> Order Report
      </div>
      <div class="panel-body">

        <!-- Report Form -->
        <form class="form-horizontal" action="php_action/getOrderReport.php" method="post" id="getOrderReportForm">
          <div class="form-group">
            <label for="startDate" class="col-sm-2 control-label">Start Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="startDate" name="startDate" placeholder="YYYY-MM-DD" autocomplete="off" />
            </div>
          </div>

          <div class="form-group">
            <label for="endDate" class="col-sm-2 control-label">End Date</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" id="endDate" name="endDate" placeholder="YYYY-MM-DD" autocomplete="off" />
            </div>
          </div>

          <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
              <button type="submit" class="btn btn-success" id="generateReportBtn">
                <i class="glyphicon glyphicon-ok-sign"></i> Generate Report
              </button>
            </div>
          </div>
        </form>

      </div> <!-- /panel-body -->
    </div> <!-- /panel -->
  </div> <!-- /col-md-12 -->
</div> <!-- /row -->

<!-- Datepicker Setup -->
<script>
  $(function () {
    $("#startDate, #endDate").datepicker({
      dateFormat: "yy-mm-dd"
    });
  });
</script>

<!-- Optional: Your own JS file for validation -->
<!-- <script src="custom/js/report.js"></script> -->

<?php require_once 'includes/footer.php'; ?>
