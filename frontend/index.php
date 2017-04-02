<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Turtle</title>
    <link rel="stylesheet" href="style.css">
    <script type="text/javascript" src="jquery-3.2.0.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
  </head>
  <body>
    <table style="width:100%"><tr>
      <td>
      </td>

      <td>
        <table style="width:100%"><tr>
          <td><button type="button" onclick="javascript:save($('#code').val(), $('#filename').val())">SPARA / SAVE:</button>
	  <input id="filename" type="text" cols="60"></td>
          <td><button type="button" onclick="javascript:run($('#code').val())">K&Ouml;R / RUN</button></td>
        </tr></table>
      </td>

      <td>
        <div id="resultfile"></div>
      </td>

    </tr><tr>
	
      <td>
        <nav>
	  <ul id="portfolio">
	    <li><a href="#" onclick="javascript:load('kvadrat.py')">kvadrat.py</a></li><li><a href="#" onclick="javascript:load('turtle.py')">turtle.py</a></li>	  </ul>
	</nav>
        <nav>
	  <ul id="history">
	    <li><a href="#" onclick="javascript:load('302.py')">302.py</a></li><li><a href="#" onclick="javascript:load('301.py')">301.py</a></li><li><a href="#" onclick="javascript:load('300.py')">300.py</a></li><li><a href="#" onclick="javascript:load('299.py')">299.py</a></li><li><a href="#" onclick="javascript:load('298.py')">298.py</a></li><li><a href="#" onclick="javascript:load('297.py')">297.py</a></li><li><a href="#" onclick="javascript:load('296.py')">296.py</a></li><li><a href="#" onclick="javascript:load('295.py')">295.py</a></li><li><a href="#" onclick="javascript:load('294.py')">294.py</a></li><li><a href="#" onclick="javascript:load('0.py')">0.py</a></li>	  </ul>
	</nav>
      </td>
      
      <td>
        <textarea id="code" rows="30" cols="80">from turtle import f, b, v, h, r, l, u, n, d, p</textarea>
      </td>
      
      <td>
        <textarea id="result" rows="30" cols="60"></textarea>
      </td>
    </tr></table>
  </body>
</html>
