<!DOCTYPE html>
  <meta charset="utf-8" />
  <title>WebSocket Test</title>
  <script language="javascript" type="text/javascript">

  var wsUri = "ws://127.0.0.1:9999";
  var output;

  function init()
  {
    output = document.getElementById("output");
    testWebSocket();
  }

  function testWebSocket()
  {
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
    websocket.send(str);
    /*
    media=Custom.WIDTHxLENGTHmm, A4, Letter
	orientation-requested=3 - portrait orientation (no rotation)
	orientation-requested=4 - landscape orientation (90 degrees)
	orientation-requested=5 - reverse landscape or seascape orientation (270 degrees)
	orientation-requested=6 - reverse portrait or upside-down orientation (180 degrees)
    */
	var data=
    	{
    		data: message,
    		action: 'printpdf',    		
    		pdffileurl: 'http://www.pdf995.com/samples/pdf.pdf',
    		options: '', //option under lp -o , example: media=Letter
    		printername:'TSC_TTP_244_Pro'
    	};
    var str=JSON.stringify(data);
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

  <div id="output"></div>
  </html>