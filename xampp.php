<?php

// Path to htdocs
define('PATH_HTDOCS', 'D:\xampp\htdocs');

// Path to the windows hosts file
define('PATH_HOSTS', 'C:\Windows\System32\drivers\etc\hosts');

define('PATH_VHOSTS', 'D:\xampp\apache\conf\extra\httpd-vhosts.conf');

// Newlines
define('HOSTS_NEWLINE', "\r\n");

// Local ip
define('HOSTS_IP', '127.0.0.1');

// Additional hosts entries to add
$ADDITIONAL_HOSTS = [
    'test.localhost',
    'geno.localhost',
    'genomigrate.localhost',
    'pxccontent.localhost',
    'mobiel.localhost',
    'ffn.localhost',
    'haas.localhost',
    'test.haas.localhost',
    'concordia.localhost',
    'taifun.localhost',
    'smartfaktura.localhost',
    'v8.localhost'
];

##################################################################
# Do not change anything after this
##################################################################

class XAMPP {

    private $DOMAINS = [];

    public function scanHtdocs() {
        $Dirs = scandir(PATH_HTDOCS);

        foreach ($Dirs as $dirname) {

            if ($dirname == '.' || $dirname == '..') {
                continue;
            }

            $ini_path = PATH_HTDOCS . DIRECTORY_SEPARATOR . $dirname . DIRECTORY_SEPARATOR . 'htdocs.ini';
            if (file_exists($ini_path)) {
                $dircfg = parse_ini_file($ini_path);

                foreach($dircfg as $key=>$value){
                    $this->DOMAINS[] = [
                        'domain'    =>  $value,
                        'path'  =>  PATH_HTDOCS . DIRECTORY_SEPARATOR . $dirname
                    ];
                }

            } else {
                $this->DOMAINS[] = [
                    'domain' => $dirname,
                    'path' => PATH_HTDOCS . DIRECTORY_SEPARATOR . $dirname
                ];
            }
        }
    }

    public function writeHosts($ADDITIONAL_HOSTS = []) {
        $LINES = [];
        foreach ($this->DOMAINS as $d) {
            $LINES[] = HOSTS_IP . ' ' . $d['domain'];
            if (!empty($d['alias'])) {
                $LINES[] = HOSTS_IP . ' ' . $d['alias'];
            }
        }
        file_put_contents(PATH_HOSTS, implode(HOSTS_NEWLINE, $LINES));
    }

    public function writeVhosts() {
        $LINES = [];
        foreach ($this->DOMAINS as $d) {
            $LINES[] = '<VirtualHost *:80>';
            $LINES[] = 'ServerAdmin admin@'.$d['domain'];
            $LINES[] = 'DocumentRoot "'.$d['path'].'"';
            $LINES[] = 'ServerName '.$d['domain'];

            if (!empty($d['alias'])) {
                $LINES[] = 'ServerAlias '.$d['alias'];
            }
            $LINES[] = 'ErrorLog "logs/'.$d['domain'].'-error.log"';
            $LINES[] = 'CustomLog "logs/'.$d['domain'].'-access.log" common';
            $LINES[] = '</VirtualHost>';
            $LINES[] = '';
        }
        file_put_contents(PATH_VHOSTS, implode(HOSTS_NEWLINE, $LINES));
    }

}

$xampp = new XAMPP();
$xampp->scanHtdocs();
$xampp->writeHosts($ADDITIONAL_HOSTS);
$xampp->writeVhosts();
