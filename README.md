# GNA Network Manager (pre-alpha1)

A php application that shows the MAC Address(es) per port that are known to the switch(es). It uses the SNMP to get information from each switch and shows the results in a simple html table per switch.

## Demo
http://172.16.10.125/gnanm

## Installation
`
apt install apache2 libapache2-mod-php php-snmp
cd /var/www/html
git clone http://gitlab.kapnet.gr/kapcom01/gnanm.git
`

## Configuration
- Enable SNMP on the switch
- Add the IP Address of the switch in `switches.ini`

## Usage
Just browse the web page
