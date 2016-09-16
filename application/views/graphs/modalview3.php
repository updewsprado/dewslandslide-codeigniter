<!DOCTYPE html><html class=''>
<head><meta charset='UTF-8'><meta name="robots" content="noindex"><link rel="canonical" href="http://codepen.io/m-e-conroy/pen/ALsdF" />

<link rel='stylesheet prefetch' href='https://netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css'>
<style class="cp-pen-styles">/* Fix for Bootstrap 3 with Angular UI Bootstrap */

.modal { 
	display: block;
}

/* Custom dialog/modal headers */

.dialog-header-error { background-color: #d2322d; }
.dialog-header-wait { background-color: #428bca; }
.dialog-header-notify { background-color: #eeeeee; }
.dialog-header-confirm { background-color: #333333; }
.dialog-header-error span, .dialog-header-error h4,
.dialog-header-wait span, .dialog-header-wait h4,
.dialog-header-confirm span, .dialog-header-confirm h4 { color: #ffffff; }

/* Ease Display */

.pad { padding: 25px; }</style></head><body>
<html ng-app="modalTest" ng-init="alias='holy cow'">
  <head>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.1.5/angular.min.js"></script>
    <script src="http://angular-ui.github.io/bootstrap/ui-bootstrap-tpls-0.6.0.js" type="text/javascript"></script>
    <script src="http://m-e-conroy.github.io/angular-dialog-service/javascripts/dialogs.min.js" type="text/javascript"></script>
    <script src="/temp/modal.js"></script>
  </head>
  <body ng-controller="dialogServiceTest" class="pad">
    <h2>Bootstrap 3 & AngularJS Dialog/Modals</h2><br />
    <p>
      Demostration of my Angular-Dialog-Service module. Which can be found on Github: <a href="https://github.com/m-e-conroy/angular-dialog-service">https://github.com/m-e-conroy/angular-dialog-service</a><br />
    </p>
    <div class="row">
      <div class="col-md-12">
        <button class="btn btn-danger" ng-click="launch('error')">Error Dialog</button>
    
        <button class="btn btn-primary" ng-click="launch('wait')">Wait Dialog</button>
    
        <button class="btn btn-default" ng-click="launch('notify')">Notify Dialog</button>
    
        <button class="btn btn-success" ng-click="launch('confirm')">Confirm Dialog</button>
        
        <button class="btn btn-warning" ng-click="launch('create')">Custom Dialog</button>
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-md-12">
        <p>
          <span class="text-info">From Confirm Dialog</span>: {{confirmed}}
        </p>
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-md-12">
        <p>
          <span class="text-info">Your Name</span>: {{name}}
        </p>
        <p>
          <span class="text-info">Your Alternate Name</span>: {{alias}}
        </p>        
      </div>
    </div>
    <br />
    
  </body>
  
    <script type="text/ng-template" id="/dialogs/whatsyourname.html">
		<div class="modal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">
							<span class="glyphicon glyphicon-star"></span> User's Name
						</h4>
					</div>
					<div class="modal-body">
						<ng-form name="nameDialog" novalidate role="form">
						<div class="form-group input-group-lg" ng-class="nameDialog.username.$dirty && nameDialog.username.$invalid">
							<label class="control-label" for="username">Name:</label>
							<input type="text" class="form-control" name="username" id="username" ng-model="user.name" ng-keyup="hitEnter($event)" required>
							<!--
							<input type="text" class="form-control" name="username" id="username" ng-model="user.name" ng-keyup="hitEnter($event)" required>
							-->
							<p>Alias: <span ng-bind="alias"></span></p>
							<span class="help-block">Enter your full name, first &amp; last.</span>
						</div>
						</ng-form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" ng-click="cancel()">Cancel</button>
						<button type="button" class="btn btn-primary" ng-click="save()" ng-disabled="(nameDialog.$dirty && nameDialog.$invalid) || nameDialog.$pristine">Save</button>
					</div>
				</div>
			</div>
		</div>
    </script>  
</html>


<script src='http://codepen.io/assets/editor/live/css_live_reload_init.js'></script>
</body></html>