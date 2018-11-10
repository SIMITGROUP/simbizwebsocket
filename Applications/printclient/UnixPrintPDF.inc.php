<?php

//namespace UnixPrintPDF;


class UnixPrintPDF
{

	private $tmpfolder='/tmp';
	public function __construct()
	{		
	}

	public function print($pdffileurl='',$printername='')
	{
		echo "\nDownloading $pdffileurl...\n";		

		$filename=$this->downloadfile($pdffileurl);
		$this->sendPrintJob($filename,$printername);
	}


	public function getAvailablePrinter()
	{
		$cmd=" lpstat -p -d |  awk '{print $2}'  | grep -v 'system'";
		$output=shell_exec($cmd);
		$printerlist=explode("\n", $output);
		return $printerlist;

	}
	private function sendPrintJob($filename,$printername='')
	{

		echo "\nPrint $filename ";		
		if($printername=='')
		{
			echo "to Default Printer:";
			$cmd=sprintf("lp %s",$filename);	
		}
		else
		{
			echo "to $printername:";
			$cmd=sprintf("lp -d %s %s",$printername,$filename);		
		}
			echo "\n".$cmd;
		// shell_exec($cmd);
	}
	private function downloadfile($url='')
	{


		set_time_limit(0);
		$fileno=rand(1000,20000);
		//This is the file where we save the    information
		$filename=$this->tmpfolder . '/pdffile'.$fileno.'.pdf';
		$fp = fopen ( $filename, 'w+');
		//Here is the file we are downloading, replace spaces with %20
		$ch = curl_init(str_replace(" ","%20",$url));
		curl_setopt($ch, CURLOPT_TIMEOUT, 50);
		// write curl response to file
		curl_setopt($ch, CURLOPT_FILE, $fp); 
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		// get curl response
		curl_exec($ch); 
		curl_close($ch);
		fclose($fp);
		return $filename;
	}
}