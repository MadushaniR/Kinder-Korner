<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Welcome to Quiz</title>
</head>
<body>

<div id="container">
	<h1>Welcome to Quiz!</h1>
<form method ="" action="<?php echo base_url();?>index.php/Questions/quizdisplay">
    <input type ="submit" value = "start">
</form>
</div>

</body>
</html>
