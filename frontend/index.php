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
	    <?php
	       $files = scandir('/var/www/html/turtlescripts');
	       sort($files);
	       foreach ($files as $file) { if (preg_match('/^[^0-9].*.py$/', $file)) { print("<li><a href=\"#\" onclick=\"javascript:load('$file')\">$file</a></li>"); } }
	    ?>
	  </ul>
	</nav>
        <nav>
	  <ul id="history">
	    <?php
	       $files = scandir('/var/www/html/turtlescripts');
	       rsort($files, SORT_NUMERIC);
	       foreach ($files as $file) { if (preg_match('/^[0-9]+.py$/', $file)) { print("<li><a href=\"#\" onclick=\"javascript:load('$file')\">$file</a></li>"); } }
	    ?>
	  </ul>
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
