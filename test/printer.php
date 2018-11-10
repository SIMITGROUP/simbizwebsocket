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

  function print(filename)
  {
  	var printername=document.getElementById('printername').value;
  	var pdfurl='https://app.simitgroup.com/'+filename;
  	var data=
    	{
    		action: 'printpdf',    		
    		pdffileurl: pdfurl,
    		options: '-o media=Custom.80x60mm -o orientation-requested=6', //option under lp -o , example: media=Letter
    		printername:printername,
    		simulate:0
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
  <button onclick="print('item.pdf')">1 page</button>
  <button onclick="print('tmpitem_2.pdf')">2 page</button>
  <button onclick="print('tmpitem_3.pdf')">3 page</button>
  <label>Simulate only=0, Print=1 <input name="simulate" value="1"></label>
  <label>Printer <input name="printername" id="printername" value="TSC_TTP-244_Pro" ></label>
  
  <div id="output"></div>
  </html>