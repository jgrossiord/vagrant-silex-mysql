#!/bin/bash -e


export DEBIAN_FRONTEND=noninteractive

sudo apt-get update -y
echo grub-pc grub-pc/install_devices multiselect /dev/sda | sudo debconf-set-selections
echo grub-pc grub-pc/install_devices_disks_changed multiselect /dev/sda | sudo debconf-set-selections

sudo apt-get upgrade -y -o dir::cache::archives="/vagrant/logs/apt-cache"
