<?php

function time_converter($inputdate) {
// input format Dec-2003 out is unix format, also works out the next months unix time also.
$date = explode('-',$inputdate);
$dlist = array(
'Jan' => array( 'month' =>	'January',
				'monthnum' =>	'1'),
'Feb' => array( 'month' =>	'February',
				'monthnum' =>	'2'),
'Mar' =>  array( 'month' =>	'March',
				'monthnum' =>	'3'),
'Apr' =>  array( 'month' =>	'April',
				'monthnum' =>	'4'),
'May' =>  array( 'month' =>	'May',
				'monthnum' =>	'5'),
'Jun' =>  array( 'month' =>	'June',
				'monthnum' =>	'6'),
'Jul' =>  array( 'month' =>	'July',
				'monthnum' =>	'7'),
'Aug' =>  array( 'month' =>	'August',
				'monthnum' =>	'8'),
'Sep' =>  array( 'month' =>	'September',
				'monthnum' =>	'9'),
'Oct' =>  array( 'month' =>	'October',
				'monthnum' =>	'10'),
'Nov' =>  array( 'month' =>	'November',
				'monthnum' =>	'11'),
'Dec' =>  array( 'month' =>	'December',
				'monthnum' =>	'12')
);

$month = $dlist[$date[0]]['month'];
$startdate = strtotime ( '1 '.$month.' '.$date[1].'');

$monthnum = $dlist[$date[0]]['monthnum'];

// we need to get the new month, if december is the date of the old number we also have to create a new year.
if($monthnum == 12) {
	$newmonth = '1';
	$date[1] = $date[1]+1;
		}
		else {
		$newmonth = $monthnum+1;
	}
foreach ($dlist as $i) {
if ($i['monthnum'] == $newmonth) {
$enddate = strtotime ( '1 '.$i['month'].' '.$date[1].'');
		}
} 
return array('start' => $startdate,
			'end' =>	$enddate
			);
}	
?>