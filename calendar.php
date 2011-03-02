<?php
/**
 * A generic calendar class
 *
 */

class Calendar {
	function Calendar( $month='', $day='', $year='' ) {
		$this->set( $month, $day, $year );
	}
	
	function set( $month='', $day='', $year='' ) {
		if ( $month == '' ) {
			$this->month = date('m');
		}
		else if ( $month < 10 ) {
			$this->month = '0' . $month;
		}
		else {
			$this->month = $month;
		}
		
		if ( $day == '' ) {
			$this->day = date('d');
		}
		else if ( $day < 10 ) {
			$this->day = '0'. $day;
		}
		else {
			$this->day = $day;
		}
		
		if ( $year == '' ) {
			$this->year = date('Y');
		}
		else {
			$this->year = $year;
		}
	}
	
	function get_month() {
		$first_day = mktime( 0, 0, 0, $this->month, 1, $this->year );
		$date_info = getdate( $first_day );
		
		$num_days = date('t', $first_day );
				
		$cal_head = date('F Y', $first_day);

		$cal_html = "<table class=\"calendar\">\n";
		
		$cal_html .= "<caption>$cal_head</caption>\n";
		
		$cal_html .= "<tr><th>S</th><th>M</th><th>T</th><th>W</th><th>T</th><th>F</th><th>S</th></tr>\n";
		
		$cal_html .= "<tr>";
		
		/* handle blank days at the start of the month */
		$week_day = $date_info['wday'];

		for ( $i = 0; $i < $week_day; $i++ ) {
			$cal_html .= "<td>&nbsp;</td>";
		}

		$count = $week_day;
		
		for ( $i = 1; $i <= $num_days; $i++ ) {
			if ( $count % 7 == 0 ) {
				$cal_html .= "</tr>\n<tr>";
			}
			if ( $i == $this->day ) {
				$cal_html .= "<td class=\"today\">$i</td>";
			}
			else {
				$cal_html .= "<td>$i</td>";
			}
			$count++;			
		}
		
		/* handle blank days at the end of the month */
		while ( $count % 7 != 0 ) {
			$cal_html .= "<td>&nbsp;</td>";
			$count++;
		}
		
		$cal_html .= "</tr>\n";

		$cal_html .= "</table>\n";

		return $cal_html;
	}

	var $month;
	var $day;
	var $year;
}

?>

