<?php 
require_once( 'entry.php' ); 
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Simple Weblog</title>
<style type="text/css" media="screen">@import url(styles.css);</style>
</head>

<body>
<div class="wholepage">
<div class="banner"><h1>Simple Weblog</h1></div>
<div class="content">
<?php
if ( !empty( $_REQUEST["title"] ) && !empty( $_REQUEST["btext"] ) ) {
	$e = new Entry();
	$e->parseForm();
	$e->save();
?>
<p>Entry saved. <a href="blog.php">Go to the blog</a>.</p>
<?php
}
?>
<div class="addsite">
<p>Add an entry:</p>
<form action="blog.php" method="post">
<label for="title">Title:</label>
<input type="text" id="title" name="title" tabindex="1" /><br />
<label for="btext">Body:</label>
<textarea id="btext" name="btext" rows="5" tabindex="2"></textarea><br />
<input type="hidden" id="author" name="author" value="Tony" />
<input type="submit" id="submit" name="submit" value="Submit" tabindex="3" />
<br />
</form>
</div>
</div>
<div class="sidebar">Links</div>
<div class="footer">Footer</div>
</div>
</body>
</html>
