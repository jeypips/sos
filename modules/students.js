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
				console.log(scope.students);
				
			}, function myError(response) {
				 
			  // error
				
			});
			
			
			$('#x_content').html(loading);
			$('#x_content').load('lists/students.html', function() {
				$timeout(function() { $compile($('#x_content')[0])(scope); },100);								
				// instantiate datable
				$timeout(function() {
					$('#student').DataTable({
						"ordering": false
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
		
	};
	
	return new form();
	
});