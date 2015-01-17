<?php

$settings = array(
    
    /* -------------------------------------------------------------------
     * Directory Configuration
     * -------------------------------------------------------------------
     * These configurations are used to identify the location of the both
     * application and system folders, relative to the index.php file.
     * The default configurations are as follows:
     *
     * 'app_path' => '../application',
     * 'sys_path' => '../system',
     *
     * If you moved both folders in the same level as your index.php file
     * change your configurations as shown below:
     *
     * 'app_path' => 'application',
     * 'sys_path' => 'system',
     * -------------------------------------------------------------------
     */
    
    'app_path'              => '../application',
    'sys_path'              => '../system',
    
    /* -------------------------------------------------------------------
     * Basic Configuration
     * -------------------------------------------------------------------
     * These configurations contains information regarding your website.
     * 
     * base_url     : This is the full url of your website pointing to the
     *                index.php file, excluding the index.php itself. The
     *                value should always end with a trailing slash. e.g:
     *                
     *                'base_url' => 'http://ragnarokname.com/',
     *                or
     *                'base_url' => 'http://ragnarokname.com/cora/',
     *
     * encrypt_key  : This is a random 30-character alphanumeric string.
     *                This is used to encrypt your sessions for security.
     *                Example of this would be:
     *                eMZxG9Mpjin05MBYje91NJL0cQaGrb
     *
     *                You may use this tool for your convenience:
     *                http://www.random.org/strings/
     *
     * dev_mode     : Turn off error reports by setting this to false.
     *
     * timezone     : Timezone that your server uses. Please refer to this
     *                guide for valid timezone values:
     *                http://php.net/manual/en/timezones.php
     * -------------------------------------------------------------------
     */
    
    'base_url'              => 'http://127.0.0.1/',
    'encrypt_key'           => '',
    'dev_mode'              => true,
    'timezone'              => 'Asia/Manila',
    
    /* -------------------------------------------------------------------
     * Database Configuration
     * -------------------------------------------------------------------
     * These configurations contains information regarding your MySQL DB.
     *
     * db_host : This is the IP of your MySQL database. e.g: 127.0.0.1
     *           
     * db_user : Your database username. e.g: root
     *           
     * db_pass : Your database password.
     *           
     * db_name : Your `ragnarok` database or schema. e.g: ragnarok
     *
     * db_log_name : Your `log` database or schema. e.g: log
     * -------------------------------------------------------------------
     */
    
    'db_host'               => '127.0.0.1',
    'db_user'               => 'root',
    'db_pass'               => '',
    'db_name'               => 'ragnarok',
    'db_log_name'           => 'log',

    /* ----------------------------------------------------------------- *
     * Extra Configurations                                              *
     * ----------------------------------------------------------------- */
    
    /* -------------------------------------------------------------------
     * ROChargen
     * -------------------------------------------------------------------
     * Contains settings used by the ROChargen feature.
     *                        
     * use_iteminfo_lua     : Set to true if you are using iteminfo.lua
     *                        instead of idnum2.txt files. Usually, this
     *                        is for for servers using the newer clients.
     *                        For clients 2012-07-10a and lower, as well
     *                        as RE 2012-04-10a and lower, set to false.
     * -------------------------------------------------------------------
     */
    
    'use_iteminfo_lua'      => false,
    
);
