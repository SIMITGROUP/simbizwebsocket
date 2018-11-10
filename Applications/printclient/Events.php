<?php
/**
 * This project use for manage local printing activity from cloud service
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the MIT-LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @author kstan <kstan@simitgroup.com> 
 * @license http://www.opensource.org/licenses/mit-license.php MIT License
 */


include dirname(__FILE__).'/UnixPrintPDF.inc.php';
include dirname(__FILE__).'/UnixPrintThermal.inc.php';

use \GatewayWorker\Lib\Gateway;
//use \UnixPrintPDF;
class Events
{
    /**
     * 当客户端连接时触发
     * 如果业务不需此回调可以删除onConnect
     * 
     * @param int $client_id 连接id
     */


    public static function onConnect($client_id)
    {
        // 向当前client_id发送数据 
        Gateway::sendToClient($client_id, json_encode(['status'=>'OK','client_id'=>$client_id]));
        // 向所有人发送
        // Gateway::sendToAll("$client_id login\r\n");
    }
    
   /**
    * check message parameter
    * @param int $client_id 连接id
    * @param mixed $message, json string with at least 1 parameter action: {action: 'printpdf',url: 'http://...'}
    */
   public static function onMessage($client_id, $message)
   {
    // echo $message;
      $result=json_decode($message,true);
      

      if($result)
      {
        $action=$result['action'];
        switch($action)
        {

          case 'listpdfprinter':
            $printer=new UnixPrintPDF();
            $data=$printer->getAvailablePrinter();
            Gateway::sendToClient($client_id, json_encode(['status'=>'OK','action'=>$action,'msg'=>$data]));
          break;
          case 'printpdf':
              
            $pdffileurl=$result['pdffileurl'];
            $printername=$result['printername'];
            $options=$result['options'];
            $actiontype=$result['actiontype'];
            $printer=new UnixPrintPDF();
            $txt=$printer->print($pdffileurl,$printername,$options,$actiontype);
            Gateway::sendToClient($client_id, json_encode(['status'=>'OK','action'=>$action,'msg'=>$txt,'actiontype'=>$actiontype]));
          break;
          case 'printthermalprinter':
            $thermalprinterip=$result['thermalprinterip'];
            $thermalprinterport=$result['thermalprinterport'];
            $txt=$result['txt'];
            $printer=new UnixPrintThermal();
            $printer->print($thermalprinterip,$thermalprinterport,$txt);
          break;
          default:
            Gateway::sendToClient($client_id, json_encode(['status'=>'Failed','msg'=>'Unrecognise "action='.$action.'".']));
          break;
        }

      }
      else
      {
        Gateway::sendToClient($client_id, json_encode(['status'=>'Failed','msg'=>'Invalid json input:'.$message.', ensure you submit valid json with parameter "action".']));
      }
      
      // 
        //Gateway::sendToAll("$client_id said $message\r\n");
   }
   
   /**
    * 当用户断开连接时触发
    * @param int $client_id 连接id
    */
   public static function onClose($client_id)
   {
       // 向所有人发送 
       GateWay::sendToAll("$client_id logout\r\n");
   }
}
