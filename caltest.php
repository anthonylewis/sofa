<?php include "calendar.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SOFA Calendar Test</title>
<link rel="stylesheet" href="styles.css" type="text/css" />
</head>

<body>
<?php
$cal = new Calendar();
echo $cal->get_month();
?>
<p><a href="index.php">Back to the home page</a>.</p>
</body>
</html>
