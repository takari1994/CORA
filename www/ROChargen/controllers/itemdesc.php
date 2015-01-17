<?php

defined("__ROOT__") OR die();
defined("USE_ITEMINFO_LUA") OR die();

class ItemDesc_Controller extends Controller {
    
    public $desc;
    
    public function __construct()
    {
            $this->desc = '';
    }
    
    public function process($pseudo) {
        if(USE_ITEMINFO_LUA == FALSE) {
            $this->getfromtxt($pseudo);
        } else {
            $raw_dir = __ROOT__ . 'client\lua files\iteminfo.lua';
            $ii_dir  = str_replace('\\', '/', $raw_dir);
            if(file_exists($ii_dir))
                $this->getfromlua($pseudo,$ii_dir);
            else
                die("Error! Cannot find " . $ii_dir);
        }
        
        if(null != $this->desc) {
            $pattern = '/\^*[a-fA-F0-9]{6}/';
            echo '<pre>' . preg_replace($pattern, '', $this->desc) . '</pre>';
        } else die("Item#$pseudo does not exist!");
    }
    
    public function getfromtxt($pseudo) {
        $raw_file  = DB::get_id2desc_path();
        $file_path = Client::getFile($raw_file.'.txt');
        $contents  = file_get_contents($file_path);
        if($contents)
        {
            $pattern = '/'.$pseudo.'#(.*?)#/s';
            preg_match($pattern, $contents, $match);
            $this->desc = $match[1];
        }
    }
    
    public function getfromlua($pseudo,$ii_dir) {
        $contents = file_get_contents($ii_dir);
        if($contents)
        {
            // GET ENTIRE INFO OF ITEM#$PSEUDO
            $pattern = '/\['.$pseudo.'\](.*?)[\}].*?(\}).*?(\})/s';
            preg_match($pattern, $contents, $match);
            $obj = $match[0];
            // GET IDENTIFIED DESCRIPTION OF ITEM#$PSEUDO
            $pattern = '/identifiedDescriptionName = \{(?!.*?identifiedDescriptionName = \{)(.*?)\}/s';
            preg_match($pattern, $obj, $descObj);
            // CONVERT ESCAPED QUOTES TO HTML ENTITY
            $descObj[1] = str_replace('\"', "&quot;", $descObj[1]);
            // GET STRING BETWEEN QUOTES
            $pattern = '/"(.*?)"/s';
            preg_match_all($pattern, $descObj[1], $desc);
            // CONCATENATE STRINGS WITH NEW LINE IN BETWEEN
            foreach($desc[1] as $d) {
                $this->desc .= $d."\n";
            }
        }
    }
}