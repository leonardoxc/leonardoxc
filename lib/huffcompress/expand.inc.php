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
+	expand.inc.php
+
+	You only have to include this file in order to expand a file.
+
+	Use :
+
+	$expander = new CPRS_Expand();
+	$expander -> SetFiles("path/to/input/file", "path/to/output/file");
+	$expander -> Expand();
+
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

// Inclusions

include_once("compresslib.inc.php");

// Class definition

class CPRS_Expand extends CPRS
{
	var $icarrier;		// Carrier window for reading from input
	var $icarlen;		// Lenght of the input carrier at any given time
	
	var $ofsize;		// Size of the output file, in bytes
	
	var $ttlnodes;		// For use in Huffman Tree reconstruction

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

/*#############################################################################
#
#	Expansion functions
#
#############################################################################*/

/******************************************************************************
*
*	Reconstruct the Huffman tree transmitted in header
*
******************************************************************************/

// Inner cross-recursive function

function ReadTPForChild($par, $child, $childid, $charin)
{
	// Creating child, setting right parent and right child for parent
	
	$this -> nodes[$par] -> $child = $childid;
	
	$char = $charin == $this -> NodeCharC ? "" : $charin;
	
	$this -> nodes[$childid] = new Node($char, 0, $par);
	
	// Special business if we have a Branch Node
	// Doing all of this for the child !
	
	if ($char === "")
		$this -> ReadTreePart($childid);
}	

// Outer cross-recursive function

function ReadTreePart($nodenum)
{
	// Reading from the header, creating a child
	
	$charin = fgetc($this -> ifhand);
	$this -> ReadTPForChild($nodenum, "child0", ++$this -> ttlnodes, $charin);
	
	$charin = fgetc($this -> ifhand);
	$this -> ReadTPForChild($nodenum, "child1", ++$this -> ttlnodes, $charin);
}

// Master function

function ReconstructTree()
{
	// Creating Root Node. Here root is indexed 0.
	// It's parent is -1, it's children are as yet unknown.
	// NOTE : weights no longer have the slightest importance here
	
	$this -> nodes[0] = new Node("", 0);
	
	// Launching the business
	
	$this -> ttlnodes = 0; // Init value	
	$this -> ReadTreePart(0);
}

/******************************************************************************
*
*	Reading the compressed data bit-by-bit and generating the output.
*
*	Huffman Compression has unique-prefix property, so as soon as we recognise a code,
*	we can assume the corresponding char. All adding up, by reading $ofsize chars from the file, we should get
*	to the end of it !
*
******************************************************************************/

// Recursive function

function ReadUntilLeaf($curnode)
{
	if ($curnode -> char !== "")
		return $curnode -> char;
	
	if ($this -> BitRead1())
		return $this -> ReadUntilLeaf($this -> nodes[$curnode -> child1]);
	return $this -> ReadUntilLeaf($this -> nodes[$curnode -> child0]);
}

// Master function

function Read2MakeOutput()
{	
	for($i = 0; $i < $this -> ofsize; $i++)
	{
		// We follow the Tree down from Root with the successive bits read
		// We know we have found the character as soon as we hit a leaf Node
		
		$this -> odata .= $this -> ReadUntilLeaf($this -> nodes[0]);
	}
}

/*#############################################################################
#
#	Debug stuff
#
#############################################################################*/

/******************************************************************************
*
*	Showing how long the operation lasted.
*
******************************************************************************/

function ShowDebug_Time()
{
	echo "Expansion lasted ".round(($this -> debug_t2 - $this -> debug_t1) * 1000 )." ms<br><br>";
}

/******************************************************************************
*
*	Master Debug function, calling other ones according to debug settings.
*
******************************************************************************/

function ShowDebug()
{
	if ($this -> debug_time)
		$this -> ShowDebug_Time();
}

/*#############################################################################
#
#	Class functions
#
#############################################################################*/

/******************************************************************************
*
*	Constructor function. Setting some general variables.
*
******************************************************************************/

function CPRS_Expand()
{
	// Having general variables be set (parent function)
	
	$this -> InitSettings();
	
	// Setting a greater time limit than standard
	// Can me modified by the user later on with SetTimeLimit()
	
	$this -> SetTimeLimit(60);	
	
	// Initializing expansion-specific variables
	
	$this -> icarrier = "";
	$this -> icarlen = 0;
}

/******************************************************************************
*
*	Expand() is the principal function called to do the job.
*
******************************************************************************/

function Expand()
{
	if (!$this -> havefiles)
		$this -> Error("Files not provided");
	
	if ($this -> debug_time)
		$this -> debug_t1 = time_micro();
	
	//	
	// WORKING WITH INPUT
	//

	// From header : reading Huffman tree (with no weights, mind you)
	
	$this -> ReconstructTree();
	
	// From header : number of characters to read (ie. size of output file)
	
	$this -> ofsize = bindec($this -> BitRead(24));
	
	//
	// WORKING WITH OUTPUT
	//
	
	// Reading bit-by-bit and generating output
	
	$this -> Read2MakeOutput();
	
	// Writing the output and closing resource handles
	
	fwrite($this -> ofhand, $this -> odata);

	fclose($this -> ofhand);
	fclose($this -> ifhand);

	if ($this -> debug_time)
		$this -> debug_t2 = time_micro();
	
	// Calling Debug stuff in case any has been activated
	
	$this -> ShowDebug();
}

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

} // CPRS_Expand class

?>