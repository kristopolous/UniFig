#!/bin/bash

sudo apt-get install figlet
wget http://www.jave.de/figlet/figletfonts40.zip
unzip figletfonts40.zip
sudo co fonts/* /usr/share/figlet/
