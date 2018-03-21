<?php include_once 'authentication.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Offenses | Offline Student System</title>
	
	<link rel="icon" type="image/ico" href="pictures/logo.jpg">
	
    <!-- Bootstrap -->
    <link href="vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- iCheck -->
    <link href="vendors/iCheck/skins/flat/green.css" rel="stylesheet">
	
    <!-- bootstrap-progressbar -->
    <link href="vendors/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- JQVMap -->
    <link href="vendors/jqvmap/dist/jqvmap.min.css" rel="stylesheet"/>
	
    <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
	
	<!-- Datatables -->
    <link href="vendors/datatables.net-bs/css/dataTables.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css" rel="stylesheet">
    <link href="vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="build/css/custom.min.css" rel="stylesheet">
  </head>
<style>
input[type="checkbox"]{
  width:17px;
  height:17px; 
  cursor: pointer;
}
</style>
  <body class="nav-md" ng-app="report" ng-controller="reportCtrl" account-profile>
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.html" class="site_title"><i class="fa fa-users"></i> <span style="font-size: 16px;">Offline Student System</span></a>
            </div>

            <div class="clearfix"></div>

            <!-- menu profile quick info -->
            <div class="profile clearfix">
              <div class="profile_pic">
                <img src="{{accountProfile.picture}}" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                <span>Welcome,</span>
                <h2>{{accountProfile.fullname}}</h2>
              </div>
            </div>
            <!-- /menu profile quick info -->

            <br />

			
            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <h3>Navigation</h3>
                <ul class="nav side-menu">
                  <li><a href="index.php"><i class="fa fa-home"></i> Home</a></li>
				  <li><a href="students.php"><i class="fa fa-user"></i> Students</a></li>
				  <li><a href="offenses.php"><i class="fa fa-list-ol"></i> Offenses</a></li>
				  <li><a href="recoms.php"><i class="fa fa-book"></i> Recommendations</a></li>
                </ul>   
              </div>

            </div>
            <!-- /sidebar menu -->

            <!-- /menu footer buttons -->
             <div class="sidebar-footer hidden-small">
              <a data-toggle="tooltip" data-placement="top" title="Logout" logout-account class="pull-right">
                <span class="glyphicon glyphicon-off" aria-hidden="true"></span>
              </a>
            </div>
            <!-- /menu footer buttons -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <img src="{{accountProfile.picture}}" alt="">{{accountProfile.fullname}}
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                    <li><a href="javascript:;" logout-account><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                  </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->

        <!-- page content -->
        <div class="right_col" role="main">
         <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-print"></i> Reporting</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

                    <!-- start form for validation -->
			   <div class="x_panel">
                  <div class="x_title">
                    <h2><i class="fa fa-check"></i> Summary Report</h2>
                    <div class="clearfix"></div>
                  </div>
						<div class="col-md-3 col-sm-12 col-xs-12">
							  <label>Educational Level</label>
							  <select ng-model="filter.educational_level" class="form-control" required>
								<option value="Junior High School">Junior High School</option>
								<option value="Senior High School">Senior High School</option>
							  </select>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12">
							<label>Grade</label>
                            <select ng-model="filter.grade" class="form-control" required>
								<option ng-show="filter.educational_level=='Junior High School'" value="7">7</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="8">8</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="9">9</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="10">10</option>
								<option ng-show="filter.educational_level=='Senior High School'" value="11">11</option>
								<option ng-show="filter.educational_level=='Senior High School'" value="12">12</option>
							  </select>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12 input-group">
							<label>Section</label>
                            <select ng-model="filter.section" class="form-control" required>
								<option ng-show="filter.educational_level=='Junior High School'" value="Venus">Venus</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="Aphrodite">Aphrodite</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="Athena">Athena</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="Ceres">Ceres</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="Hestia">Hestia</option>
								<option ng-show="filter.educational_level=='Junior High School'" value="Hera">Hera</option>
								<option ng-show="filter.grade=='11'" value="Artemis">Artemis</option>
								<option ng-show="filter.grade=='11'" value="Hemera">Hemera</option>
								<option ng-show="filter.grade=='11'" value="Eros">Eros</option>
								<option ng-show="filter.grade=='11'" value="Demeter">Demeter</option>
								<option ng-show="filter.grade=='11'" value="Uranus">Uranus</option>
								<option ng-show="filter.grade=='11'" value="Themis">Themis</option>
								<option ng-show="filter.grade=='11'" value="Nyx">Nyx</option>
								<option ng-show="filter.grade=='11'" value="Apollo">Apollo</option>
								<option ng-show="filter.grade=='12'" value="Menerva">Menerva</option>
								<option ng-show="filter.grade=='12'" value="Persephone">Persephone</option>
								<option ng-show="filter.grade=='12'" value="Hades">Hades</option>
								<option ng-show="filter.grade=='12'" value="Dionysus">Dionysus</option>
								<option ng-show="filter.grade=='12'" value="Chronos">Chronos</option>
								<option ng-show="filter.grade=='12'" value="Janus">Janus</option>
								<option ng-show="filter.grade=='12'" value="Vesta">Vesta</option>
							  </select>
                            <span class="input-group-btn">
							  <button style="margin-top: 24px;" type="button" ng-click="filterReport(this)" class="btn btn-primary">Go!</button>
						    </span>
                        </div>
						
						<div class="col-md-3 col-sm-12 col-xs-12">
							  <label>Educational Level</label>
							  <select ng-model="filterSumCollege.educational_level" class="form-control" required>
								<option value="College">College</option>
							  </select>
						</div>
						<div class="col-md-3 col-sm-12 col-xs-12">
							<label>Year</label>
                            <select ng-model="filterSumCollege.year" class="form-control" required>
								<option value="1st">1st</option>
								<option value="2nd">2nd</option>
								<option value="3rd">3rd</option>
								<option value="4th">4th</option>
							</select>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12 input-group">
							<label>Course</label>
                            <select class="form-control" ng-model="filterSumCollege.course" ng-disabled="controls.ok.btn">
								<option value="BSIT">Bachelor of Science in Information Technology</option>
								<option value="CHS">Computer Hardware Services</option>
								<option value="1 year HRM">1 year Hotel and Restaurant Management</option>
								<option value="2 years HRM">2 years Hotel and Restaurant Management</option>
								<option value="BSHRM">Bachelor of Science in Hotel and Restaurant Management</option>
							</select>
                            <span class="input-group-btn">
							  <button style="margin-top: 24px;" type="button" ng-click="filterSummaryCollege(this)" class="btn btn-primary">Go!</button>
						    </span>
                        </div>
                    </div>
		
					<!-- <div class="x_panel">
						<div class="x_title">
							<h2><i class="fa fa-check"></i> Single Report - High School</h2>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<label>ID Number</label>
								<input type="number" ng-model="filterSingle.id_number" class="form-control">
							</select>
						</div>
						
						<div class="col-md-3 col-sm-12 col-xs-12">
							<button style="margin-top: 23px;" type="button" ng-click="filterReportSingle(this)" class="btn btn-primary">Go!</button>
						</div>
					</div>
				
					<div class="x_panel">
						<div class="x_title">
							<h2><i class="fa fa-check"></i> Single Report - College</h2>
							<div class="clearfix"></div>
						</div>
						<div class="col-md-6 col-sm-12 col-xs-12">
							<label>ID Number</label>
								<input type="number" ng-model="filterCollege.id_number" class="form-control">
							</select>
						</div>
						
						<div class="col-md-3 col-sm-12 col-xs-12">
							<button style="margin-top: 23px;" type="button" ng-click="filterReportCollege(this)" class="btn btn-primary">Go!</button>
						</div>
					</div> -->
					
					
				<form id="filterSumCollege" action="reports/sumcollege.php" method="post" target="_blank">
					<input type="hidden" name="params" value="{{filterSumCollege}}">
				</form>
				<form id="filterCollege" action="reports/collegereport.php" method="post" target="_blank">
					<input type="hidden" name="params" value="{{filterCollege}}">
				</form>
                <form id="filter_report" action="reports/template.php" method="post" target="_blank">
					<input type="hidden" name="params" value="{{filter}}">
				</form>
				<form id="filterSingle" action="reports/singlereport.php" method="post" target="_blank">
					<input type="hidden" name="params" value="{{filterSingle}}">
				</form>
                    <!-- end form for validations -->

                  </div>
                </div>
        </div>
        <!-- /page content -->

        <!-- footer content -->
        <footer>
          <div class="pull-right">
            Copyright &copy;  <strong><?php echo date("Y"); ?></strong> Student Offline System.
          </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
      </div>
    </div>

    <!-- jQuery -->
    <script src="vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="vendors/nprogress/nprogress.js"></script>
    <!-- Chart.js -->
    <script src="vendors/Chart.js/dist/Chart.min.js"></script>
    <!-- gauge.js -->
    <script src="vendors/gauge.js/dist/gauge.min.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
    <!-- Skycons -->
    <script src="vendors/skycons/skycons.js"></script>

    <!-- DateJS -->
    <script src="vendors/DateJS/build/date.js"></script>
    <!-- JQVMap -->
    <script src="vendors/jqvmap/dist/jquery.vmap.js"></script>
    <script src="vendors/jqvmap/dist/maps/jquery.vmap.world.js"></script>
    <script src="vendors/jqvmap/examples/js/jquery.vmap.sampledata.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="vendors/moment/min/moment.min.js"></script>
    <script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
	
	<!-- Datatables -->
    <script src="vendors/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="vendors/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>
    <script src="vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>
    <script src="vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
    <script src="vendors/datatables.net-scroller/js/dataTables.scroller.min.js"></script>
    <script src="vendors/jszip/dist/jszip.min.js"></script>
    <script src="vendors/pdfmake/build/pdfmake.min.js"></script>
    <script src="vendors/pdfmake/build/vfs_fonts.js"></script>
	
    <!-- Custom Theme Scripts -->
    <script src="build/js/custom.min.js"></script>
	<script src="vendors/bootbox/bootbox.min.js"></script>
	<script src="vendors/growl/jquery.bootstrap-growl.min.js"></script> 	
	
	<!-- Custom Theme Scripts -->
    <script src="angular/angular.min.js"></script>
	<script src="modules/ui-bootstrap-tpls-2.5.0.min.js"></script>
    <script src="modules/fullscreen.js"></script>
    <script src="modules/bootstrap-modal.js"></script>
    <script src="modules/account.js"></script>
    <script src="modules/growl.js"></script>
    <script src="modules/offenses.js"></script>
	<script type="text/javascript">

	var app = angular.module('report',['toggle-fullscreen','account-module','offenses-module']);
	
	app.controller('reportCtrl',function($scope,form) {

		form.data($scope);
		
		$scope.filter = {
			educational_level: '',
			grade: '',
			section: ''
		};
		
		$scope.filterSingle = {
			id_number: ''
		};
		
		$scope.filterCollege = {
			id_number: ''
		};
		
		$scope.filterSumCollege = {
			educational_level: 'College',
			year: '',
			course: ''
		};
		
		$scope.filterReport = function(scope) {
			
			$('#filter_report').submit();
			console.log($scope.filter);
		};
		
		$scope.filterReportSingle = function(scope) {
			
			$('#filterSingle').submit();
		};
		
		$scope.filterReportCollege = function(scope) {
			
			$('#filterCollege').submit();
		};
		$scope.filterSummaryCollege = function(scope) {
			
			$('#filterSumCollege').submit();
		};
		
	});

</script>
  </body>
</html>
