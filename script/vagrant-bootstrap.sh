#!/bin/bash -e

sudo apt-get update -y
sudo apt-get upgrade -y -o dir::cache::archives="/vagrant/logs/apt-cache"
