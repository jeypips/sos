angular.module('students-module',['bootstrap-modal','bootstrap-growl','snapshot-module']).factory('form', function($compile,$timeout,$http,bootstrapModal,growl,snapshot) {
	
	function form() {
		
		var self = this;
		
		var loading = '<div class="col-sm-offset-4 col-sm-8"><button type="button" class="btn btn-dark" title="Loading" disabled><i class="fa fa-spinner fa-spin"></i>&nbsp; Please wait...</button></div>';
		
		self.data = function(scope) { // initialize data			
			
			// scope.mode = null;
			
			scope.snapshot = snapshot;
			
			scope.pictures = {
				front: null
			};
			
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
				
			scope.student = {};
			scope.student.student_id = 0;
	
			scope.students = []; // list
		};

		function validate(scope) {
			
			var controls = scope.formHolder.student.$$controls;
			
			angular.forEach(controls,function(elem,i) {
				
				if (elem.$$attr.$attr.required) elem.$touched = elem.$invalid;
									
			});

			return scope.formHolder.student.$invalid;
			
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

		self.student = function(scope,row) {	
		
			scope.student = {};
			scope.student.student_id = 0;
			
			mode(scope,row);
			
			$('#x_content').html(loading);
			$('#x_content').load('forms/student.html',function() {
				$timeout(function() { $compile($('#x_content')[0])(scope); },200);
			});
			
			if (row != null) {
				
				if (scope.$id > 2) scope = scope.$parent;				
				$http({
				  method: 'POST',
				  url: 'handlers/student-view.php',
				  data: {student_id: row.student_id}
				}).then(function mySucces(response) {
					
					angular.copy(response.data, scope.student);
					scope.student.date = new Date(response.data.date);
					angular.forEach(scope.pictures, function(item,i) { console.log(i);
						var photo = 'pictures/'+scope.student.student_id+'_'+i+'.png';
						var view = document.getElementById(i+'_picture');
						if (imageExists(photo)) view.setAttribute('src', photo);
						else view.setAttribute('src', 'pictures/avatar.png');
					});
					
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
			  url: 'handlers/student-save.php',
			  data: {student: scope.student}
			}).then(function mySucces(response) {
				
				if (scope.student.student_id == 0) {
					scope.student.student_id = response.data;
					growl.show('alert alert-success alert-dismissible fade in',{from: 'top', amount: 55},'Basic Information successfully added.');
					}	else{
						growl.show('alert alert-success alert-dismissible fade in',{from: 'top', amount: 55},'Basic Information successfully updated.');
					}
					mode(scope,scope.student);
					snapshot.upload(scope);
			}, function myError(response) {
				 
			  // error
				
			});			
			
		};		
		
		self.delete = function(scope,row) {
			
		var onOk = function() {
			
			if (scope.$id > 2) scope = scope.$parent;			
			
			$http({
			  method: 'POST',
			  url: 'handlers/student-delete.php',
			  data: {student_id: [row.student_id]}
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
			
			scope.student = {};
			scope.student.student_id = 0;			
			$http({
			  method: 'POST',
			  url: 'handlers/student-list.php',
			}).then(function mySucces(response) {
				
				scope.students = response.data;
				
			}, function myError(response) {
				 
			  // error
				
			});
			
			
			$('#x_content').html(loading);
			$('#x_content').load('lists/students.html', function() {
				$timeout(function() { $compile($('#x_content')[0])(scope); },100);								
				// instantiate datable
				$timeout(function() {
					$('#student').DataTable({
						// "ordering": false,
						 // "processing": true,
						 "processing": true,
						 "language": {
						  processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '}						
						
					});	
				},200);
				
			});				
			
		};
		
		function imageExists(image_url){

			var http = new XMLHttpRequest();

			http.open('HEAD', image_url, false);
			http.send();

			return http.status != 404;

		};
		
		self.print = function(scope,student) {
			
			$http({
			  method: 'POST',
			  url: 'handlers/print-student.php',
			  data: {student_id: student.student_id}
			}).then(function mySucces(response) {
				
				if (scope.student.student_id == 0) {
				} else {
				print(scope,response.data);
				}
			}, function myError(response) {
				 
			  // error
				
			});
					
			
		};
		
		function print(scope,student) {
		
		var doc = new jsPDF('p','mm','legal');
		
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
		doc.text(20, 30, 'Date added:');
		doc.text(70, 30, student[0].date);
		
		doc.text(20, 40, 'ID number:');
		doc.text(70, 40, ''+student[0].id_number);
		
		doc.text(20, 50, 'Full Name:');
		doc.text(70, 50, student[0].lastname+','+' '+student[0].firstname+' '+student[0].middlename);
		
		doc.text(20, 60, 'Educational Level:');
		doc.text(70, 60, ''+student[0].educational_level);
		
		doc.text(20, 70, 'Grade:');
		doc.text(70, 70, ''+student[0].grade+''+student[0].senior_grade);
		
		doc.text(20, 80, 'Section:');
		doc.text(70, 80, ''+student[0].section+''+student[0].senior_section);

		doc.text(20, 90, 'Strand:');
		doc.text(70, 90, ''+student[0].strand);
		//
		doc.text(20, 100, 'Year:');
		doc.text(70, 100, ''+student[0].year);
		
		doc.text(20, 110, 'Course:');
		doc.text(70, 110, ''+student[0].course);
		
		//
		doc.text(20, 120, 'Date');
		doc.text(20, 130, ''+student[0].offs_date);
		
		doc.text(70, 120, 'Offenses');
		doc.text(70, 130, ''+student[0].inc_uniform);
		
		doc.text(130, 120, 'Community Service');
		doc.text(140, 130, ''+student[0].com_service+' '+'minutes');
		
		doc.text(180, 120, 'Remarks');
		doc.text(180, 130, ''+student[0].done);
		
		doc.text(20, 140, ''+student[1].offs_date);
		
		doc.text(70, 140, ''+student[1].inc_uniform);
		
		doc.text(140, 140, ''+student[1].com_service+' '+'minutes');
		
		doc.text(180, 140, ''+student[1].done);
		
		
			
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