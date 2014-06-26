<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Sets up validation for a form, then checks if the form is valid when clicking a button.</title>
<link rel="stylesheet" href="http://jquery.bassistance.de/validate/demo/site-demos.css">
<style>
 
  </style>
</head>
<body>
<form id="myform">
<form id="myform">
  <input type="text" name="name" required>
  <br>
  <button type="button">Validate!</button>
</form>
</form>
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://jquery.bassistance.de/validate/jquery.validate.js"></script>
<script src="http://jquery.bassistance.de/validate/additional-methods.js"></script>
<script>
// just for the demos, avoids form submit
jQuery.validator.setDefaults({
  debug: true,
  success: "valid"
});
var form = $( "#myform" );
form.validate();
$( "button" ).click(function() {
  //alert( "Valid: " + form.valid() );
});
</script>
</body>
</html>