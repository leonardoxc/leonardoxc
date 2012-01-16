<?
//************************************************************************
// Leonardo XC Server, http://www.leonardoxc.net
//
// Copyright (c) 2004-2010 by Andreadakis Manolis
//
// This program is free software. You can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation; either version 2 of the License.
//
// $Id: CL_pdf.php,v 1.1 2012/01/16 07:21:23 manolis Exp $                                                                 
//
//************************************************************************


class leoPdf {
	function leoPdf() {

	}

	function createPDF($url,$batchDir='',$forcedName=''){
		global $CONF;
		
		$hashkey=md5($url);
		
		$tmpDir=$CONF['pdf']['tmpPath'].'/';		
		if ($batchDir) {
			$batchDir=$batchDir.'/';
			$tmpDir.=$batchDir;
		}		
		
		$tmpFile=$hashkey.'.pdf';
		
		if ($forcedName) $tmpFile=$forcedName;
		 
		@mkdir($tmpDir);
		
		$cmd="cd $tmpDir; ".$CONF['pdf']['pdfcreator']." '$url' $tmpFile";
		echo "createPDF: Will exec $cmd<BR>";
		exec($cmd);
		
		// echo "#######".$tmpDir.$tmpFile;
		if (is_file($tmpDir.$tmpFile)) {
			return $batchDir.$tmpFile;
		} else {
			return 0;
		}
		
					
	}
	
	function createPDFmulti($urlArray,$batchDir){
		global $CONF;
		$i=1;
		
		//do {
		//	$batchDir=rand(0,10000000);
		//} while (is_dir($CONF['pdf']['tmpPath'].'/'.$batchDir)) ;
		
		@mkdir($CONF['pdf']['tmpPath'].'/'.$batchDir);
		
		$i=1;
		//print_r($urlArray );
		ksort($urlArray);
		foreach($urlArray as $ii=>$url) {
			$hashkey=md5($url);
			$tmpFile=$CONF['pdf']['tmpPath'].'/'.$batchDir.'/'.sprintf("%05d",$i).'_'.$hashkey.'.pdf';
			if( ! is_file($tmpFile)) {
				$pdf=leoPDF::createPDF($url,$batchDir,sprintf("%05d",$i).'_'.$hashkey.'.pdf');
				if ($pdf) $pdfFiles[]=$pdf;
			} else {
				$pdfFiles[]=$batchDir.'/'.sprintf("%05d",$i).'_'.$hashkey.'.pdf';
			}
			$i++;
		}
		
		// print_r($pdfFiles);

		$filename=$CONF['pdf']['tmpPath'].'/'.$batchDir."/logbook.pdf";
		if (is_file($filename)) {
			echo "Final PDF already exists: $filename\n";
			return $batchDir."/logbook.pdf";
		}
			
		if ($CONF['pdf']['pdftk']) {
			$cmd=" cd ".$CONF['pdf']['tmpPath'].'/'.$batchDir." ;  pdftk *.pdf cat output logbook.pdf";
			
			// $cmd=" cd ".$CONF['pdf']['tmpPath']." ;  gs -dBATCH -dNOPAUSE -q -sDEVICE=pdfwrite -sOutputFile=finished.pdf *.pdf";
			
			echo "Will exec $cmd<BR>";
			exec($cmd);
			// print_r($out);
		} else {
			require_once dirname(__FILE__).'/lib/PDFMerger/PDFMerger.php';

			$pdf = new PDFMerger;
			
			foreach($pdfFiles as $pdfFile){
				echo "Adding ".$CONF['pdf']['tmpPath'].'/'.$pdfFile."<br>\n";
				$pdf->addPDF($CONF['pdf']['tmpPath'].'/'.$pdfFile, 'all');
			}
			//echo "now merging->\n";
			$pdf->merge('file', $filename);		
			//echo "merged...\n";
		}
		
		
		
		/// echo "$filename\n";
		if (is_file($filename)) {
			// echo "loggobok $filename \n";
			return $batchDir."/logbook.pdf";
		} else {
			return 0;
		}
		//foreach ($pdfFiles as $pdfFile) {
		//	echo "joining $pdfFile<BR>";
		//}
		// now join them				
	}
}

?>