angular.module('offenses-module',['ui.bootstrap','bootstrap-modal','bootstrap-growl']).factory('form', function($compile,$timeout,$http,bootstrapModal,growl) {
	
	function form() {
		
		var self = this;
		
		var loading = '<div class="col-sm-offset-4 col-sm-8"><button type="button" class="btn btn-dark" title="Loading" disabled><i class="fa fa-spinner fa-spin"></i>&nbsp; Please wait...</button></div>';
		
		self.data = function(scope) { // initialize data			
			
			// scope.mode = null;
			
			scope.controls = {
				ok: {
					btn: false,
					label: 'Save'
				},
				cancel: {
					btn: false,
					label: 'Cancel'
				},
			};
				
			scope.offense = {};
			scope.offense.offense_id = 0;
	
			scope.offenses = []; // list
			
			$http({
				method: 'POST',
				url: 'api/suggestions/students.php'
			}).then(function mySucces(response) {
				
				scope.students = response.data;
				
			},function myError(response) {
				
			});
		};

		function validate(scope) {
			
			var controls = scope.formHolder.offense.$$controls;
			
			angular.forEach(controls,function(elem,i) {
				
				if (elem.$$attr.$attr.required) elem.$touched = elem.$invalid;
									
			});

			return scope.formHolder.offense.$invalid;
			
		};
		
		function mode(scope,row) {
			
			if (row == null) {
				scope.controls.ok.label = 'Save';
				scope.controls.ok.btn = false;
				scope.controls.cancel.label = 'Cancel';
				scope.controls.cancel.btn = false;
			} else {
				scope.controls.ok.label = 'Update';
				scope.controls.ok.btn = true;
				scope.controls.cancel.label = 'Close';
				scope.controls.cancel.btn = false;				
			}
			
		};

		self.offense = function(scope,row) {	
		
			scope.offense = {};
			scope.offense.offense_id = 0;
			
			mode(scope,row);
			
			$('#x_content').html(loading);
			$('#x_content').load('forms/recom.html',function() {
				$timeout(function() { $compile($('#x_content')[0])(scope); },200);
			});
			
			if (row != null) {
				
				if (scope.$id > 2) scope = scope.$parent;				
				$http({
				  method: 'POST',
				  url: 'handlers/offense-view.php',
				  data: {offense_id: row.offense_id}
				}).then(function mySucces(response) {
					
					angular.copy(response.data, scope.offense);
					scope.offense.recom_date = new Date(response.data.recom_date);
					
				}, function myError(response) {
					 
				  // error
					
				});					
			};
		
		};
		
		
		self.edit = function(scope) {
			
			scope.controls.ok.btn = !scope.controls.ok.btn;
			
		};
		
		self.save = function(scope) {
			
			if (validate(scope)){ 
			growl.show('alert alert-danger alert-dismissible fade in',{from: 'top', amount: 55},'Please complete required fields.');
			return;
			}
			
			
			$http({
			  method: 'POST',
			  url: 'handlers/recom-save.php',
			  data: {offense: scope.offense}
			}).then(function mySucces(response) {
				
				if (scope.offense.offense_id == 0) {
					scope.offense.offense_id = response.data;
					growl.show('alert alert-success alert-dismissible fade in',{from: 'top', amount: 55},'Basic Information successfully added.');
					}	else{
						growl.show('alert alert-success alert-dismissible fade in',{from: 'top', amount: 55},'Basic Information successfully updated.');
					}
					mode(scope,scope.offense);
				
			}, function myError(response) {
				 
			  // error
				
			});			
			
		};		
		
		self.delete = function(scope,row) {
			
		var onOk = function() {
			
			if (scope.$id > 2) scope = scope.$parent;			
			
			$http({
			  method: 'POST',
			  url: 'handlers/offense-delete.php',
			  data: {offense_id: [row.offense_id]}
			}).then(function mySucces(response) {

				self.list(scope);
				
				growl.show('alert alert-danger alert-dismissible fade in',{from: 'top', amount: 55},'Basic Information successfully deleted.');
				
			}, function myError(response) {
				 
			  // error
				
			});

		};

		bootstrapModal.confirm(scope,'Confirmation','Are you sure you want to delete this record?',onOk,function() {});
			
		};
		
		self.list = function(scope) {
			
			scope.offense = {};
			scope.offense.offense_id = 0;			
			$http({
			  method: 'POST',
			  url: 'handlers/recom-list.php',
			}).then(function mySucces(response) {
				
				scope.offenses = response.data;
				console.log(scope.offenses);
				
			}, function myError(response) {
				 
			  // error
				
			});
			
			$('#x_content').html(loading);
			$('#x_content').load('lists/recoms.html', function() {
				$timeout(function() { $compile($('#x_content')[0])(scope); },100);								
				// instantiate datable
				$timeout(function() {
					$('#recom').DataTable({
						"ordering": false
					});	
				},200);
				
			});				
			
		};
		
		self.fullnameSelect = function($item, scope) {
			
			scope.offense.student_no = $item;
			
		};
		
		self.print = function(scope,offense) {
			
			$http({
			  method: 'POST',
			  url: 'handlers/print-recom.php',
			  data: {offense_id: offense.offense_id}
			}).then(function mySucces(response) {
				
				if (scope.offense.offense_id == 0) {
				} else {
				print(scope,response.data);
				console.log(response.data);
				}
			}, function myError(response) {
				 
			  // error
				
			});
					
			
		};
		
		function print(scope,offense) {
		console.log(scope.offense);
		
		var doc = new jsPDF('p','mm','letter');
		
		doc.setFontSize(16)
		doc.setFont('times');
		doc.setFontType('normal');
		//X-axis, Y-axis
		doc.text(60, 10, 'La Union Colleges of Science and Technology');
		doc.text(85, 20, 'Student Information');
		
		doc.setFontSize(14)
		doc.setFont('times');
		doc.setFontType('normal');
		//X-axis, Y-axis
		doc.text(20, 30, 'Date:');
		doc.text(25, 40, offense[0].recom_date);
		
		doc.text(20, 50, 'Full Name:');
		doc.text(25, 60, offense[0].fullname);
		
		doc.text(20, 70, 'Recommendation:');
		doc.text(25, 80, ''+offense[0].admitted_excuse+''+offense[0].academic_loses+''+offense[0].admitted_notexcuse+''+offense[0].parent_notification+''+offense[0].dropped+''+offense[0].completion_required+''+offense[0].recom_others);
	
		doc.text(20, 90, 'Total of Community Service:');
		doc.text(25, 100, ''+offense[0].total+' '+'minutes');
		
		doc.text(20, 110, 'Offenses:');
		doc.text(25, 120, ''+offense[0].inc_uniform+''+offense[0].late_tardy+''+offense[0].no_id+''+offense[0].cutting_classes+''+offense[0].absent+''+offense[0].others);
		
		doc.text(20, 130, 'Remarks:');
		doc.text(25, 140, ''+offense[0].done);
			
		/* var lMargin=30; //left margin in mm
		var rMargin=5; //right margin in mm
		var pdfInMM=130;  // width of A4 in mm
		var lines = doc.splitTextToSize(''+offense[0].dropped+''+offense[0].completion_required, (pdfInMM-lMargin-rMargin));
		doc.text(lMargin,70,lines); */
		
			var blob = doc.output('blob');
			window.open(URL.createObjectURL(blob));
		
		
		};
		
	};
	
	return new form();
	
});