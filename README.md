# TurtleIDE
Web based IDE for editing and executing Python code on wifi connected Turtle robot.

## Introduction
In the seventies, Seymour Papert invented LOGO as a teaching tool for computer programming, encouraging exploration and interactivity. The accompanying Turtle robot could draw sketches on paper, creating a tangible thing from the programming effort. Now, the concept has been recreated on a platform base on Raspberry Pi and Python. Read more about the project at http://formallanguage.blogspot.se/2017/04/designing-turtle.html.

The code in this repository is what you need in addition to a Raspbian installation to get a fully functional IDE with remote editing and code execution on the Turtle robot.

## The Backend
The backend consists of two services that take care of execution and storage of programs.

The script run.sh executes Python programs. It listens on http://localhost:3481 for HTTP POST requests containing Python code in the request body. The response contains the name of the file where the result of the program execution can be read. The script preserves a log of all executed programs which makes it easy to go back to earlier versions of the program during exploratory and iterative development.

The script save.sh writes Python programs to disk. It listens on http://localhost:3482/{name} for HTTP POST requests containing Python code in the request body. The code will be writte to the file {name}.py.

turtle.py contains code to drive the stepper motors and the servo on the Turtle robot. It uses pigpio for GPIO and servo control.

To install the backend on the Raspberry Pi, copy all three files to /home/pi and make them executable.
```
wget https://raw.githubusercontent.com/TheOtherMarcus/TurtleIDE/master/backend/run.sh
wget https://raw.githubusercontent.com/TheOtherMarcus/TurtleIDE/master/backend/save.sh
wget https://raw.githubusercontent.com/TheOtherMarcus/TurtleIDE/master/backend/turtle.py
chmod +x run.sh save.sh
crontab -e
```
Add the following lines to crontab.
```
@reboot  mkdir -p /home/pi/turtlescripts
@reboot  cp /home/pi/turtle.py /home/pi/turtlescripts/turtle.py
@reboot  (cd /home/pi; ./run.sh turtlescripts)
@reboot  (cd /home/pi; ./save.sh turtlescripts)
```
It is possible to overwrite turtle.py from the IDE, but the code in crontab will always restore the original version at reboot.

We also need to run the pigpio daemon at startup, this time as root.
```
sudo crontab -e
```
Add the following line to crontab.
```
@reboot  /usr/bin/pigpiod
```

## The Frontend
The frontend is implemeted in HTML, CSS, PHP, Javascript and jQuery.

First you need to install and configure the Apache web server. Run the following commands on the Raspberry Pi.

```
sudo apt-get install apache2 php5 libapache2-mod-php5
sudo a2enmod proxy_http
sudo nano /etc/apache2/sites-enabled/000-default.conf
```
The file 000-default.conf should look something like this. Two proxy lines have been added at the end.
```
<VirtualHost *:80>
	# The ServerName directive sets the request scheme, hostname and port that
	# the server uses to identify itself. This is used when creating
	# redirection URLs. In the context of virtual hosts, the ServerName
	# specifies what hostname must appear in the request's Host: header to
	# match this virtual host. For the default virtual host (this file) this
	# value is not decisive as it is used as a last resort host regardless.
	# However, you must set it for any further virtual host explicitly.
	#ServerName www.example.com

	ServerAdmin webmaster@localhost
	DocumentRoot /var/www/html

	# Available loglevels: trace8, ..., trace1, debug, info, notice, warn,
	# error, crit, alert, emerg.
	# It is also possible to configure the loglevel for particular
	# modules, e.g.
	#LogLevel info ssl:warn

	ErrorLog ${APACHE_LOG_DIR}/error.log
	CustomLog ${APACHE_LOG_DIR}/access.log combined

	# For most configuration files from conf-available/, which are
	# enabled or disabled at a global level, it is possible to
	# include a line for only one particular virtual host. For example the
	# following line enables the CGI configuration for this host only
	# after it has been globally disabled with "a2disconf".
	#Include conf-available/serve-cgi-bin.conf

	ProxyPass "/run" "http://localhost:3481"
	ProxyPass "/save" "http://localhost:3482"
</VirtualHost>

# vim: syntax=apache ts=4 sw=4 sts=4 sr noet
```
Continue with the configuration.
```
sudo service apache2 restart
cd /var/www/html
sudo mv index.html index.debian
sudo ln -s /home/pi/turtlescripts .
sudo wget https://code.jquery.com/jquery-3.2.0.min.js
```
Finally, copy all files in the frontend directory to /var/www/html.
```
cd /var/www/html
sudo wget https://raw.githubusercontent.com/TheOtherMarcus/TurtleIDE/master/frontend/index.php
sudo wget https://raw.githubusercontent.com/TheOtherMarcus/TurtleIDE/master/frontend/script.js
sudo wget https://raw.githubusercontent.com/TheOtherMarcus/TurtleIDE/master/frontend/style.css
```

## Running the IDE
You are now all set to run the IDE. Reboot the Raspberry Pi, figure out which IP address it was assigned and open the URL http://{IP}/ in a browser. Happy Turtling!
