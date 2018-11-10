<!DOCTYPE html>
  <meta charset="utf-8" />
  <title>WebSocket Test</title>
  <script language="javascript" type="text/javascript">

  var wsUri = "";
  var output;

  function init()
  {
    output = document.getElementById("output");
    // testWebSocket();
  }

  function testWebSocket()
  {

  	wsUri=document.getElementById('socketval').value;
  	console.log('socket:'+wsUri);
    websocket = new WebSocket(wsUri);
    websocket.onopen = function(evt) { onOpen(evt) };
    websocket.onclose = function(evt) { onClose(evt) };
    websocket.onmessage = function(evt) { onMessage(evt) };
    websocket.onerror = function(evt) { onError(evt) };
  }



  function onOpen(evt)
  {
    writeToScreen("CONNECTED");
   doSend("WebSocket rocks");
  }

  function printpdf(filename)
  {
  	var printername=document.getElementById('printername').value;
  	var actiontype=document.getElementById('actiontype').value;
  	var pdfurl='https://app.simitgroup.com/'+filename;
  	var data=
    	{
    		action: 'printpdf',    		
    		pdffileurl: pdfurl,
    		options: '-o media=Custom.80x60mm -o orientation-requested=6', //option under lp -o , example: media=Letter
    		printername:printername,
    		actiontype:actiontype
    	};
    var str=JSON.stringify(data);
    writeToScreen("Print:"+str);
    websocket.send(str);
  }

  function printthermalprinter(filename)
  {

  	var thermalprinterip=document.getElementById('thermalprinterip').value;
  	var thermalprinterport=document.getElementById('thermalprinterport').value;
  	var thermaltxt=document.getElementById('thermaltxt').value;
  	var data=
    	{
    		action: 'printthermalprinter',    		
    		txt: thermaltxt,    		
    		printername:printername
    	};
    var str=JSON.stringify(data);
    writeToScreen("Print:"+str);
    websocket.send(str);

  }
  function onClose(evt)
  {
    writeToScreen("DISCONNECTED");
  }

  function onMessage(evt)
  {
    writeToScreen('<pre style="color: blue;">RESPONSE: ' + evt.data+'</pre>');
    // websocket.close();
  }

  function onError(evt)
  {
    writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
  }

  function doSend(message)
  {
    writeToScreen("SENT: " + message);
    var data=
    	{
    		data: message,
    		action: 'listpdfprinter',    		
    	};
    var str=JSON.stringify(data);
    writeToScreen(str);
    websocket.send(str);	
  }

  function writeToScreen(message)
  {
    var pre = document.createElement("p");
    pre.style.wordWrap = "break-word";
    pre.innerHTML = message;
    output.appendChild(pre);
  }

  window.addEventListener("load", init, false);

  </script>

  <h2>WebSocket Test</h2>
  <label>Socket <input name="socketval" id="socketval" value="ws://simitzone.tplinkdns.com:9999" ></label>
  <button onclick="testWebSocket()">Connect</button>
  <div>
  	  <h2>Print PDF</h2>
	  <button onclick="printpdf('item.pdf')">1 page pdf</button>
	  <button onclick="printpdf('tmpitem_2.pdf')">2 page pdf</button>
	  <button onclick="printpdf('tmpitem_3.pdf')">3 page pdf</button>
	  <label>Type<input name="actiontype" id="actiontype" value="simulate">(print will print, others value no print)</label>
	  <label>Printer <input name="printername" id="printername" value="TSC_TTP-244_Pro" ></label>
  </div>
  <div>

  	<h2>Print Network Thermal Printer</h2>
  	<div>
  		<label>text to print at thermal receipt printer <br/>
  			<textarea id="thermaltxt" cols="80" rows="10">
  				 	  This is sample
  			    data with long - long text...
			============================================
  			           footer content
  			</textarea>
  		</label>
  	</div>
  	<div>
  		<label>Printer IP
  			<input name="thermalprinterip" id="thermalprinterip" value="192.168.0.245"/>
  		</label>
  		<label>Network Port
  			<input name="thermalprinterport" id="thermalprinterport" value="9100"/>
  		</label>
  	</div>
  	<button onclick="printthermalprinter()">Print to thermal receipt printer</button>
  </div>
  <div id="output"></div>
  </html>