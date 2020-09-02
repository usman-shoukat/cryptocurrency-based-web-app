<?php
/**
 * Created by PhpStorm.
 * User: Badshah
 * Date: 12/7/2018
 * Time: 12:02 AM
 */
session_start();
class Database
{
    protected $connection;
    public $siteUrl;
    public $protocol;

    public function __construct()
    {
        $this->connection = new mysqli('localhost', 'trueface_investor', 'Ammar174243', 'trueface_investor') or die("<h1>Database connection couldn't be established.</h1>");
        $this->protocol = 'http';
        if (isset($_SERVER['HTTPS'])) {
            if (strtoupper($_SERVER['HTTPS']) == 'ON') {
                $this->protocol = 'https';
            }
        }
        $this->siteUrl = $this->protocol."://" . $_SERVER['HTTP_HOST'];
    }

    /**
     * @return mysqli
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param mysqli $connection
     */
    public function setConnection($connection)
    {
        $this->connection = $connection;
    }

    /**
     * @param $string
     * @return string
     */
    public function escapeString($string){
       return $this->connection->real_escape_string($string);
    }

    /**
     * @return string
     */
    public function getUrl(){
        return $this->siteUrl;
    }

    /**
     * @return string
     */
    public function getProtocol(){
        return $this->protocol;
    }

    /**
     * @param bool $isRedirect
     * @param string $redirectPage
     */
    public static function isLoginRequired($isRedirect = true, $redirectPage = '/index.php'){
        if ($isRedirect){
            if (empty($_SESSION['email'])) {
                header('location:' . $redirectPage);
            }
        }
    }


    public static function isUserAlreadyLogin(){
        if (!empty($_SESSION['email'])){
            header('location:/dashboard.php');
        }
    }

    /**
     * @return string
     */
    public static function getPublicSiteUrl(){
        $self = new self();
        return $self->getUrl();
    }
    public static function getActivePage(){
        $page = basename($_SERVER['PHP_SELF']);
        return  substr($page,0,strpos($page,'.'));
    }
}