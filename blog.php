<?php require_once( 'entry.php' ); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Simple Weblog</title>
<link rel="stylesheet" type="text/css" media="screen" href="styles.css"/>
<link rel="stylesheet" type="text/css" media="print" href="styles.css"/>
</head>
<body>
<div class="wholepage">
<div class="banner"><h1><a href="blog.php">Simple Weblog</a></h1></div>
<div class="content">
<?php
$e = new Entry();

$where = '';

if ( !empty( $_REQUEST['id'] ) ) {
  $where = "id=" . $_REQUEST['id'];
}

$e->get_list( $where, 'post_date desc', 5 );

while( $e->next() ) {
?>
<div class="entry">
<h2><a href="?id=<?php echo $e->id ?>"><?php echo $e->title; ?></a></h2>
<?php echo $e->formatText(); ?>
<div class="tagline">Posted by <?php echo $e->author; ?> on <?php echo $e->formatDate() ?></div>
</div>
<?php
}
?>
</div>
<div class="sidebar">Links</div>
<div class="footer">Footer</div>
</div>
</body>
</html>
