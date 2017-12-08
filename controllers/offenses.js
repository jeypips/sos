var app = angular.module('offenses',['toggle-fullscreen','account-module','offenses-module']);

app.controller('offensesCtrl',function($scope,fullscreen,form) {
	
	$scope.views = {};
	$scope.formHolder = {};
	$scope.fullscreen =  fullscreen;
	
	form.data($scope);
	form.list($scope);
	
	$scope.form = form;

});