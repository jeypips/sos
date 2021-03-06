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
			$('#x_content').load('forms/offense.html',function() {
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
					scope.offense.offs_date = new Date(response.data.offs_date);
					
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
			  url: 'handlers/offense-save.php',
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
			  url: 'handlers/offense-list.php',
			}).then(function mySucces(response) {
				
				scope.offenses = response.data;
				console.log(scope.offenses);
				
			}, function myError(response) {
				 
			  // error
				
			});
			
			$('#x_content').html(loading);
			$('#x_content').load('lists/offenses.html', function() {
				$timeout(function() { $compile($('#x_content')[0])(scope); },100);								
				// instantiate datable
				$timeout(function() {
					$('#offense').DataTable({
						"ordering": false
					});	
				},200);
				
			});				
			
		};
		
		self.fullnameSelect = function($item, scope) {
			
			scope.offense.student_no = $item;
			
		};
		
		
		self.myFunction = function() {
			
			window.print();
			
		};
		
		

		
	};
	
	return new form();
	
});