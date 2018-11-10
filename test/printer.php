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

	var data=
    	{
    		data: message,
    		action: 'printpdf',    		
    		pdffileurl: 'http://www.pdf995.com/samples/pdf.pdf',
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