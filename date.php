<?php

// MySQL's DATETIME format = 'YYYY-MM-DD HH:MM:SS'

$datetime = '2004-11-19 19:04:37';

echo "$datetime<br/>";
echo "<br />";

list( $year, $month, $day, $hour, $minute, $second ) = split( '[- :]', $datetime );

echo "Year: $year<br/>";
echo "Month: $month<br/>";
echo "Day: $day<br/>";
echo "Hour: $hour<br/>";
echo "Minute: $minute<br/>";
echo "Second: $second<br/>";
echo "<br />";

/*
// 'YYYY-MM-DD HH:MM:SS'
$pattern = '/(\d{4})-(\d{2})-(\d{2}) (\d{2}):(\d{2}):(\d{2})/';
preg_match( $pattern, $datetime, $match );

$year = $match[1];
$month = $match[2];
$day = $match[3];
$hour = $match[4];
$minute = $match[5];
$second = $match[6];
*/

list( $year, $month, $day, $hour, $minute, $second ) = preg_split( '/[- :]/', $datetime );
echo "Year: $year<br/>";
echo "Month: $month<br/>";
echo "Day: $day<br/>";
echo "Hour: $hour<br/>";
echo "Minute: $minute<br/>";
echo "Second: $second<br/>";
echo "<br />";

list( $date, $time ) = explode( ' ', $datetime );
list( $year, $month, $day ) = explode( '-', $date );
list( $hour, $minute, $second ) = explode( ':', $time );

echo "Year: $year<br/>";
echo "Month: $month<br/>";
echo "Day: $day<br/>";
echo "Hour: $hour<br/>";
echo "Minute: $minute<br/>";
echo "Second: $second<br/>";
echo "<br />";

$months = array( 1 => 'January', 'February', 'March', 'April', 'May', 'June', 
		 'July', 'August', 'September', 'October', 'November', 'December' );

$ampm = 'AM';

if ( $hour > 12 ) {
	$hour -= 12;
	$ampm = 'PM';
}

echo "{$months[$month]} $day, $year at $hour:$minute $ampm.<br/>";

?>
