<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>SOFA Task List Test</title>
</head>

<body>
<?php
require_once( 'task.php' );

$tl = new Task();

$tl->get_list();

while( $tl->next() ) {
?>
<h2><?php echo $tl->title; ?></h2>
<p><?php echo $tl->description; ?></p>
<?php
}
?>
<p><a href="index.php">Back to the home page</a>.</p>
</body>
</html>
