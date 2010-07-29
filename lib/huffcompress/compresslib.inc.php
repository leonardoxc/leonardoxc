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
+	compresslib.inc.php
+
+	You do not need to include this file. It it automatically included
+	once and once only by compress.inc.php or by expand.inc.php
+
+	Elements common to Compression and Expansion
+
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

// Inclusions

include_once("customlib.inc.php");

// Node class

class Node
{
	var $char;		// Coded character
	var $w;			// Character weight in the Huffman tree
	var $par;		// Parent ID
	var $child0;	// ID of Child 0
	var $child1;	// ID of Child 1
	var $LNdone;	// "Done" in finding lightest nodes in original tree construction
	
	function Node($char, $w, $par = -1, $child0 = -1, $child1 = -1)
	{
		$this -> char = $char;
		$this -> w = $w;
		$this -> par = $par;
		$this -> child0 = $child0;
		$this -> child1 = $child1;
		$this -> LNdone = FALSE;
	}
}

// Principal class : CPRS

class CPRS
{
	var $debug_time;	// Whether to calculate operation duration
	var $debug_t1;		// If so, first instant
	var $debug_t2;		// Likewise, second instant
		
	var $havefiles;		// Boolean to check files have been passed
	var $NodeChar;		// Character representing a Branch Node in Tree transmission
	var $NodeCharC;		// The same, character version as opposed to binary string
	
	var $ifile; 		// Path to the input file
	var $ifhand; 		// Resource handle of the input file
	
	var $ofile; 		// Path to the output file
	var $ofhand;		// Resource handle of the output file
	var $odata;			// Data eventually written to the output file

	var $nodes;			// Array of Node objects
	
/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

/*#############################################################################
#
#	Varied purpose functions
#
#############################################################################*/

/******************************************************************************
*
*	Fatal error call
*
******************************************************************************/

function Error($msg)
{
	exit("<b>CPRS error :</b> $msg");
}

/******************************************************************************
*
*	Can be used to set a specific time limit if the user is dissatisfied with
*	the standard 60s set by this class.
*
******************************************************************************/

function SetTimeLimit($sec = 60)
{
	set_time_limit($sec);
}

/******************************************************************************
*
*	Bit-writing with a carrier : output every 8 bits
*
******************************************************************************/

function BitWrite($str, $len)
{
	// $carrier is the sequence of bits, in a string	
	
	$this -> ocarrier .= $str;
	$this -> ocarlen += $len;
	
	while($this -> ocarlen >= 8)
	{
		$this -> odata .= chr(bindec(substr($this -> ocarrier, 0, 8)));
		$this -> ocarrier = substr($this -> ocarrier, 8);
		$this -> ocarlen -= 8;
	}
}

/******************************************************************************
*
*	Finalizing bit-writing, writing the data
*
******************************************************************************/

function BitWrite_End()
{
	// If carrier is not finished, complete it to 8 bits with 0's and write it out
	// Adding n zeros is like multipliying by 2^n
	
	if ($this -> ocarlen)
		$this -> odata .= chr(bindec($this -> ocarrier) * pow(2, 8 - $this -> ocarlen));
	
	// Writing the whole output data to file
	
	fwrite($this -> ofhand, $this -> odata);
}

/******************************************************************************
*
*	Bit-reading with a carrier : input 8 bits at a time
*
******************************************************************************/

function BitRead($len)
{
	// Fill carrier 8 bits (1 char) at a time until we have at least $len bits
	
	// Determining the number n of chars that we are going to have to read
	// This might be zero, if the icarrier is presently long enough
	
	$n = ceil(($len - $this -> icarlen) / 8);
	
	// Reading those chars, adding each one as 8 binary digits to icarrier
	
	for ($i = 0; $i < $n; $i++)
		$this -> icarrier .= DecBinDig(ord(fgetc($this -> ifhand)), 8);
		
	// Getting the portion of icarrier we want to return
	// Then diminishing the icarrier of the returned digits
	
	$ret = substr($this -> icarrier, 0, $len);
	$this -> icarrier = substr($this -> icarrier, $len);
	
	// Adding the adequate value to icarlen, taking all operations into account
	
	$this -> icarlen += 8 * $n - $len;
	
	return $ret;
}

function BitRead1()
{
	// Faster reading of just 1 bit
	// WARNING : requires icarrier to be originally empty !
	// NO keeping track of carrier length
	
	if ($this -> icarrier == "")
		$this -> icarrier = DecBinDig(ord(fgetc($this -> ifhand)), 8);
	
	$ret = substr($this -> icarrier, 0, 1);
	$this -> icarrier = substr($this -> icarrier, 1);
	
	return $ret;
}

/*#############################################################################
#
#	Class functions
#
#############################################################################*/

/******************************************************************************
*
*	Initializing general variables in the class (default values and such)
*
******************************************************************************/

function InitSettings()
{	
	$this -> debug_time = FALSE;
	
	$this -> havefiles = FALSE;
	$this -> NodeChar = "00000111";
	$this -> NodeCharC = chr(7);
	
	$this -> odata = "";
	$this -> nodes = array();
}

/******************************************************************************
*
*	SetFiles() is called to specify the paths to the input and output files.
*	Having set the relevant variables, it gets resource pointers to the files
*	themselves.
*
*	This parent function is actually called by a homonym in both
*	compress.inc.php and expand.inc.php .
*
******************************************************************************/

function SetFiles($ifile = "", $ofile = "")
{
	// Setting general variables concerning files
	
	if (trim($ifile) == "")
		$this -> Error("No input file provided");
	else
		$this -> ifile = $ifile;
	
	if (trim($ofile) == "")
		$this -> Error("No output file provided");
	else
		$this -> ofile = $ofile;
	
	// Getting resource handles to the input and output files
	
	if (!($this -> ifhand = @fopen($this -> ifile, "rb")))
		$this -> Error("Unable to open input file");
	
	if (!($this -> ofhand = @fopen($this -> ofile, "wb")))
		$this -> Error("Unable to open output file");
		
	// Stating that files have been gotten
	
	$this -> havefiles = TRUE;
}

/******************************************************************************
*
*	Activating certain debugging trackers. $debugstr is a string of space-
*	separated elements, like "time scodes ratio" for example.
*
******************************************************************************/

function SetDebug($debugstr)
{
	$debugarr = explode(" ", $debugstr);
	
	foreach($debugarr as $debugelem)
	{
		$debugelem = "debug_".$debugelem;
		if (isset($this -> $debugelem)) $this -> $debugelem = TRUE;
	}
}

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

} // CPRS class

?>