#!/bin/sh
echo $1
cd /www
tar -xvf $1
chmod +x cgi-bin/*
