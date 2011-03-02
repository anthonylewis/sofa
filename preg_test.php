<html>
<body>

<?php

$text = " http://www.google.com/ asdf  http://www.parisisd.net/ asdf   http://slashdot.org/";

preg_match_all( '/(http:\/\/\S+[A-Za-z0-9\/])/', $text, $matches );

foreach( $matches[0] as $match ) {
	echo "<p>$match</p>\n";
}

$text = "Hello\r\nWorld!\rThis is a test\nI hope it works";

$text = preg_replace( "/\r\n|\r/", "\n", $text );

echo "<pre>$text</pre>";

?>

</body>
</html>