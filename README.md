# RESTful Network Manager (pre-alpha2)

Detects network devices using ARP and gathers information about them using SNMP. All data is provided through a REST API.

## Installation
    apt install php-snmp php-sqlite3 composer netdiscover
    git clone http://gitlab.kapnet.gr/kapcom01/restnm.git
    cd restnm
    composer install

## Configuration
    cp switches.ini.example switches.ini
    sudo php start-update.php

## Run
    php restnm.php 0.0.0.0:3000
