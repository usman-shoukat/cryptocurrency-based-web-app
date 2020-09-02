<?php
/**
 * Created by PhpStorm.
 * User: Badshah
 * Date: 12/8/2018
 * Time: 2:48 AM
 */
require_once 'Database.php';

class SiteHelper extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    public static function makeUrl($directory = '',$page = '', $parems = [])
    {
        $siteHelper = new self();
        $url = $siteHelper->getUrl();
        if(!empty($directory)){
            $url .= '/'.$directory;
        }
        if(!empty($page)){
            $url .= '/'.$page;
        }

        if(!empty($parems)){
            $url .= '?'.http_build_query($parems);
        }
        return $url;
    }
}