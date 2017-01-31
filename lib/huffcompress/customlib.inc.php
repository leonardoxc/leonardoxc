<?

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
+
+	HUFFMAN STATIC COMPRESSION
+	A PHP Implementation
+
+	by Exaton (exaton@free.fr)
+
+	Released as Freeware.
+	Use & modify as you see fit, no guarantee provided.
+
+	See README file for version info.
+
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+
+
+	customlib.inc.php
+
+	You do not need to include this file. It it automatically included
+	once and once only by compresslib.inc.php
+
+	Other useful functions
+
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

/******************************************************************************
*
*	Print an array
*
******************************************************************************/

function gprint($arr)
{
	echo "<pre>\n";
	print_r($arr);
	echo "</pre>\n";
}

/******************************************************************************
*
*	Def : float time_micro(void)
*
*	Returns the number of seconds since the Unix Epoch, with trailing
*	microseconds as decimals.
*
*	For duration calculation, multiply result of a time_micro() difference by
*	1000000 to get a number of microseconds, by 1000 to get a number of
*	milliseconds.
*
******************************************************************************/

function time_micro()
{
	list($usec, $sec) = explode(" ", microtime());
	return (float)$sec + (float)$usec;
}

/******************************************************************************
*
*	Def : string DecBinDig(int $x, int $n)
*
*	Returns the binary representation of $x as a string, over $n digits, with
*	as many initial zeros as necessary to cover that. 
*	
*	Note : $n has to be more digits than the binary representation of $x
*	originally has !
*
******************************************************************************/

function DecBinDig($x, $n)
{
	return substr(decbin(pow(2, $n) + $x), 1);
}

?>