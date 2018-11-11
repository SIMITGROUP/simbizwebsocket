<?php

//namespace UnixPrintThermal;


class UnixPrintThermal
{
	protected $errormsg;
	protected $errorno;
	public function __construct()
	{

	}

	public function getErrorInfo()
	{


	}
	public function print($printerip='',$printerport=9100,$txt='')
	{
		$receipt = $txt;
		if($printerport=='')
		{
			$printerport==9100;
		}
		if($printerip !='')
		{
			$fp = fsockopen($printerip,$printerport,$errno,$errstr,2);
			
	        if (!$fp)
	        {
	    		$this->errorno=$errno;
	    		$this->errormsg=$errstr;
	            $msg = "Printer IP: $printerip with port '$printerport' </br>Error: $errstr ($errno)<br/>\n";
	            return ['status'=>'Failed','msg'=>$msg];
	        }
	        else
				{
	                //fputs($fp, 'Access-Control-Allow-Origin: *');
	                //fputs($fp, 'Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS');
	                //fputs($fp, 'Access-Control-Max-Age: 1000');
	                //fputs($fp, 'Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');
	                //fputs($fp, 'Content-Type: application/x-www-form-urlencodedrn');
	                fwrite($fp, $receipt);
	                fclose($fp);
	                return ['status'=>'OK'];
	        }
        }
        else
        {
        	    return ['status'=>'Failed','msg'=>'Please supply valid printer ip'];
        }
	}

}