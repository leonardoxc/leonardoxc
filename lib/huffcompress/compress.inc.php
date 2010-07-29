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
+	compress.inc.php
+
+	You only have to include this file in order to compress a file.
+
+	Use :
+
+	$compressor = new CPRS_Compress();
+	$compressor -> SetFiles("path/to/input/file", "path/to/output/file");
+	$compressor -> Compress();
+
+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

// Inclusions

include_once("compresslib.inc.php");

// Class definition

class CPRS_Compress extends CPRS
{
	var $debug_scodes;	// Whether to show sorted character codes produced
	var $debug_ratio; 	// Whether to show compression ratio	
	
	var $ocarrier;		// Carrier window for writing to output
	var $ocarlen;		// Lenght of the output carrier at any given time
	
	var $ifsize; 		// Size of the input file, in bytes
	var $occ;			// Array of letter occurrences
	var $hroot;			// Index of the root of the Huffman tree
	var $codes;			// Array of character codes
	var $codelens;		// Array of character code lengths

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

/*#############################################################################
#
#	Compression functions
#
#############################################################################*/

/******************************************************************************
*
*	Count character occurrences in the file, to identify information
*	quantities and later construct the Huffman tree.
*
******************************************************************************/

function CountOccurrences()
{
	while(($char = fgetc($this -> ifhand)) !== FALSE)
	{	
		if (!isset($this -> occ[$char]))
			$this -> occ[$char] = 1;
		else
			$this -> occ[$char]++;
	}
}

/******************************************************************************
*
*	Convert the character occurrences to basic Nodes of according weight.
*
******************************************************************************/

function Occs2Nodes()
{
	foreach($this -> occ as $char => $nboccs)
		$this -> nodes[] = new Node($char, $nboccs);
}

/******************************************************************************
*
*	Get the index of the first node of lightest weight in the nodes array.
*
******************************************************************************/

function FindLightestNode()
{
	$minw_nodenum = -1;
	$minw = -1;
	
	foreach($this -> nodes as $nodenum => $node)
	{
		if (!$node -> LNdone && ($minw == -1 || $node -> w < $minw))
		{
			$minw = $node -> w;
			$minw_nodenum = $nodenum;
		}
	}
	
	return $minw_nodenum;
}

/******************************************************************************
*
*	Create the Huffman tree, after the following algorithm :
*	- Find the two nodes of least weight (least info value)
*	- Set each one's parent to the index a new node which has a weight equal to the sum of weights of the two
*	- At the same time, specify the new nodes children as being the two lightest nodes
*	- Eliminate the two lightest nodes from further searches for lightest nodes
*
*	This carries on until there is only one node difference between nodes
*	constructed and nodes done : the root of the tree.
*
*	By following the tree from root down to leaf, by successive children 0 or
*	1, we can thereafter establish the code for the character.
*
******************************************************************************/

function MakeHuffmanTree()
{
	$nbnodes = count($this -> nodes);
	$nbnodesdone = 0;
	
	while($nbnodesdone < $nbnodes - 1)
	{
		// Find two lightest nodes and consider them done
		
		for($i = 0; $i < 2; $i++)
		{
			$ln[$i] = $this -> FindLightestNode();
			$this -> nodes[$ln[$i]] -> LNdone = TRUE;
		}
		
		$nbnodesdone += 2;
		
		// Link them with a parent node of sum weight
		// (whose parent is as yet unknown ; in the case of root, it will stay with -1)
		
		$this -> nodes[] = new Node("", $this -> nodes[$ln[0]] -> w + $this -> nodes[$ln[1]] -> w, -1, $ln[0], $ln[1]);
			
		$this -> nodes[$ln[0]] -> par = $nbnodes; // The number of nodes before incrementation is the index
		$this -> nodes[$ln[1]] -> par = $nbnodes; //  of the node which has just been created
		
		$nbnodes++;
	}
	
	// Note that the last node is the root of the tree
	
	$this -> hroot = $nbnodes - 1;
}

/******************************************************************************
*
*	Read the Huffman tree to determine character codes.
*
******************************************************************************/

function MakeCharCodes()
{
	// Note : original alphabet is the keys of $occ
	
	$i = 0;
	
	foreach($this -> occ as $char => $nbocc)
	{
		$code = "";
		$codelen = 0;
		
		// Following tree back up to root
		// (therefore _pre_positionning each new bit in the code)
		// $this -> nodes[$i] is the original Node of $char
		
		$curnode = $i;
		
		do
		{
			$parnode = $this -> nodes[$curnode] -> par;
			$code = ($this -> nodes[$parnode] -> child0 == $curnode ? "0" : "1") . $code;
			$codelen++;
			$curnode = $parnode;
		}
		while($curnode != $this -> hroot);
		
		$this -> codes[$char] = $code;
		$this -> codelens[$char] = $codelen;
		
		$i++;
	}
}

/******************************************************************************
*
*	Transmit the Huffman tree in header
*
******************************************************************************/

// Recursive function

function TransmitTreePart($nodenum, $isroot)
{
	// Transmitting current node representation, if we are not working with root (that's only the first time).
	// Then looking at children if appropriate (gee that sounds bad).
	
	$curnode = $this -> nodes[$nodenum];
	$char = $curnode -> char;
			
	if ($char === "")
	{
		// Branch Node
		// Being root can only be in this case
		
		if (!$isroot)
			$this -> BitWrite($this -> NodeChar, 8);
		
		// Looking at children
		
		$this -> TransmitTreePart($curnode -> child0, FALSE);
		$this -> TransmitTreePart($curnode -> child1, FALSE);
	}
	else
	{
		// Leaf Node
		// Just transmitting the char
		
		$this -> BitWrite(DecBinDig(ord($char), 8), 8);
	}
}

// Master function

function TransmitTree()
{
	// Launching the business, specifying that we are starting at root	
	
	$this -> TransmitTreePart($this -> hroot, TRUE);
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
	echo "Compression lasted ".round(($this -> debug_t2 - $this -> debug_t1) * 1000 )." ms<br><br>";
}

/******************************************************************************
*
*	Show info on characters codes created from the Huffman tree.
*
******************************************************************************/

function ShowDebug_Scodes()
{	
	// Sorting codes
	
	arsort($this -> occ);
	
	// Preparing informative $scodes array
	
	foreach($this -> occ as $char => $nbocc)
	{
		$tmp = "";
		
		if (ord($char) >= 32)
			$schar = $char;
		else
		{
			$schar = "µ";
			$tmp = " (ASCII : ".ord($char).")";
		}
		
		$nboccprefix = "";
		for($i = 0; $i < 6 - strlen($nbocc); $i++)
			$nboccprefix .= "0";
			
		$occpercent = round($nbocc / $this -> ifsize * 100, 2);
					
		$scodes[$schar] = "(".$nboccprefix.$nbocc." occurences, or ".$occpercent."%) ".$this -> codes[$char]." (code on ".$this -> codelens[$char]." bits)".$tmp;
	}
	
	// Printing $scodes array in <pre>
	
	gprint($scodes);
}

/******************************************************************************
*
*	Shows compression ratio (output size calculated through simulation)
*
******************************************************************************/

function ShowDebug_Ratio()
{	
	echo "INPUT FILE SIZE : ".$this -> ifsize." bytes";
	
	// Simulating output file size
	
	$csize = 0;
	
	foreach($this -> occ as $char => $nbocc)
		$csize += $nbocc * $this -> codelens[$char];
	
	$nbchars = count($this -> occ);
	
	$csize += 16 * ($nbchars - 1); // For Huffman tree in header
	$csize += 24; // For nb. chars to read
	
	$csize = ceil($csize / 8);
	
	echo "<br><br>COMPRESSED SIZE : $csize bytes";
	
	$cratio = round($csize / $this -> ifsize * 100, 2);
	
	echo "<br><br>That's ".$cratio."% of original size, or ".(100 - $cratio)."% compression !";
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
	
	if ($this -> debug_scodes)
		$this -> ShowDebug_Scodes();	
		
	if ($this -> debug_ratio)
		$this -> ShowDebug_Ratio();
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

function CPRS_Compress()
{
	// Having general variables be set (parent function)
	
	$this -> InitSettings();
	
	// Initializing compression-specific variables
	
	$this -> debug_scodes = FALSE;
	$this -> debug_ratio = FALSE;
	
	$this -> ocarrier = "";
	$this -> ocarlen = 0;
}

/******************************************************************************
*
*	SetFiles() is called to specify the paths to the input and output files.
*	It calls a parent function for its role, then sets some compression-
*	specific variables concerning files.
*
******************************************************************************/

function SetFiles($ifile = "", $ofile = "")
{
	// Calling the parent function for this role
	
	parent :: SetFiles($ifile, $ofile);
	
	// Setting compression-specific variables concerning files
	
	$this -> ifsize = filesize($this -> ifile);
}

/******************************************************************************
*
*	Compress() is the principal function called to do the job.
*
******************************************************************************/

function Compress()
{
	if (!$this -> havefiles)
		$this -> Error("Files not provided");
	
	if ($this -> debug_time)
		$this -> debug_t1 = time_micro();
	
	//	
	// WORKING WITH INPUT
	//

	// Counting letter occurrences in input file

	$this -> CountOccurrences();
	
	// Converting occurrences into basic nodes
	// The nodes array has been initialized, as it will be filled with dynamic incrementation
	
	$this -> Occs2Nodes();
	
	// Construction of the Huffman tree
	
	$this -> MakeHuffmanTree();

	// Constructing character codes
	
	$this -> MakeCharCodes();
	
	//
	// WORKING WITH OUTPUT
	//

	//!! No need for 8 bits of nb of chars in alphabet ?? still use $this -> nbchars ? NO
	//!! No need for 8+5+codelen bits of chars & codes ?? still use $this -> codelens array ? YES
	
	// Header : passing the Huffman tree with an automatically stopping algorithm
	
	$this -> TransmitTree();

	// End of header : number of chars actually encoded, over 3 bytes
		
	$this -> BitWrite(DecBinDig($this -> ifsize, 24), 24);

	// Contents : compressed data
	
	rewind($this -> ifhand);
	
	while(($char = fgetc($this -> ifhand)) !== FALSE)
		$this -> BitWrite($this -> codes[$char], $this -> codelens[$char]);

	// Finalising output, closing file handles
	
	$this -> BitWrite_End();
	
	fclose($this -> ofhand);
	fclose($this -> ifhand);

	if ($this -> debug_time)
		$this -> debug_t2 = time_micro();
	
	// Calling Debug stuff in case any has been activated
	
	$this -> ShowDebug();
}

/*+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+*/

} // CPRS_Compress class

?>