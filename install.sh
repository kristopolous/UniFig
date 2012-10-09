#!/bin/bash

sudo apt-get install figlet
[ -e figletfonts40.zip ] || wget http://www.jave.de/figlet/figletfonts40.zip
[ -e fonts ] || unzip figletfonts40.zip
sudo cp fonts/* /usr/share/figlet/
