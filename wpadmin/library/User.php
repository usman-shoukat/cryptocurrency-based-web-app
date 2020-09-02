<?php
/**
 * Created by PhpStorm.
 * User: Badshah
 * Date: 12/7/2018
 * Time: 12:08 AM
 */
require_once 'Database.php';

class User extends Database
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return array
     */
     
    public function signUp()
    {
         $referrelId = $_GET['refl'];
         $refl = $referrelId;
         
         $referrelId2 = $_GET['refl2'];
         $refl2 = $referrelId2;
         
         $referrelId3 = $_GET['refl3'];
         $refl3 = $referrelId3;
         
         $referrelId4 = $_GET['refl4'];
         $refl4 = $referrelId4;
       
        if (empty($_POST['username'])) {
            return ['status' => 'error', 'message' => 'Full name field is required.'];
        }
        if (empty($_POST['email'])) {
            return ['status' => 'error', 'message' => 'Email field is required.'];
        }
        if (empty($_POST['password'])) {
            return ['status' => 'error', 'message' => 'Password field is required.'];
        }
         
         
        if (empty($_POST['password_confirmation'])) {
            return ['status' => 'error', 'message' => 'Password field is required.'];
        }
        if ($_POST['password'] != $_POST['password_confirmation']) {
            return ['status' => 'error', 'message' => 'Please provide a valid confirm password.'];
        }
        $userName = $this->escapeString(substr($_POST['email'], 0, strpos($_POST['email'], '@')));
      
        $email = $this->escapeString($_POST['email']);
        
        $password = $this->escapeString(md5($_POST['password']));
        $reflId = $this->escapeString(md5(time()));
        $ref_id2 = $this->escapeString(uniqid(time()));
        $gold = md5($ref_id2);
        $ref_id3 = $this->escapeString(uniqid(time()));
         $plat = md5($ref_id3);
        $ref_id5 = $this->escapeString(uniqid(time()));
        $daim = md5($ref_id5);
   
        if (!empty($email)) {
            $sql = "SELECT * FROM users where email='" . $email . "'";
            $result = $this->getConnection()->query($sql);
            if ($result->num_rows > 0) {
                return ['status' => 'error', 'message' => $email . ' is already associated with an other account.'];
            }
        }
        $sql = "INSERT INTO `users` (`username`, `email`, `password`,`my_btcx`, `referral_id`, `ref_id2`, `ref_id3`, `ref_id4`) VALUES ('" . $userName . "','" . $email . "','" . $password . "',5,'". $reflId . "','". $gold . "','". $plat . "','". $daim . "')";
        
        $result  = $this->getConnection()->query($sql);
        
        $userId = $this->getConnection()->insert_id;
       
        if (!empty($refl)) {
            $sql = "SELECT * FROM users where referral_id = '" . $refl . "'";
            $result = $this->getConnection()->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_object();
                $sql = "INSERT INTO user_referrals (`user_id`,`referred_by`) VALUES ('" . $userId . "','" . $row->id . "')";
                $this->getConnection()->query($sql);

                $sql = "INSERT INTO user_balance (`user_id`,`referred_to`,`usd`,`adjusted_amout`) VALUES ('" . $row->id . "','" . $userId . "',0.5,5)";
                $this->getConnection()->query($sql);
            }
        }
        
        
        if (!empty($refl2)) {
            $sql2 = "SELECT * FROM users where ref_id2 = '" . $refl2 . "'";
            $result2 = $this->getConnection()->query($sql2);
            if ($result2->num_rows > 0) {
                $row2 = $result2->fetch_object();
                $sql3 = "INSERT INTO gold (`user_id`,`ref_id`,`ref_by`,`usd`,`adjusted_amout`) VALUES ('" . $userId . "','" . $row2->ref_id2 . "','" . $row2->id . "',1,5)";
                $this->getConnection()->query($sql3);

              
            }
        }
        
        
         if (!empty($refl3)) {
            $sql3 = "SELECT * FROM users where ref_id3 = '" . $refl3 . "'";
            $result3 = $this->getConnection()->query($sql3);
            if ($result3->num_rows > 0) {
                $row3 = $result3->fetch_object();
                $sql4 = "INSERT INTO platinum (`user_id`,`ref_id`,`ref_by`,`usd`,`adjust_amount`) VALUES ('" . $userId . "','" . $row3->ref_id3 . "','" . $row3->id . "',2,5)";
                $this->getConnection()->query($sql4);

              
            }
        }
        
         if (!empty($refl4)) {
            $sql4 = "SELECT * FROM users where ref_id4 = '" . $refl4 . "'";
            $result4 = $this->getConnection()->query($sql4);
            if ($result4->num_rows > 0) {
                $row4 = $result4->fetch_object();
                $sql5 = "INSERT INTO daimond (`user_id`,`ref_id`,`ref_by`,`usd`,`adjust_amount`) VALUES ('" . $userId . "','" . $row4->ref_id4 . "','" . $row4->id . "',3,5)";
                $this->getConnection()->query($sql5);

              
            }
        }
        
       
        

            $this->signIn();
        return ['status' => 'success', 'message' => 'Your account has been created. Please login to continue.'];
    }


    
    public function signIn()
    {
        if (empty($_POST['email'])) {
            return ['status' => 'error', 'message' => 'Email field is required.'];
        }
        if (empty($_POST['password'])) {
            return ['status' => 'error', 'message' => 'Password field is required.'];
        }
        $email = $this->escapeString($_POST['email']);
        $password = md5($_POST['password']);

        $sql = "SELECT * FROM users where email='" . $email. "'";
        $result = $this->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            if($row->password === $password){
                $this->setUserSession($row,$this->getUrl().'/dashboard.php');
            }else{
                return ['status' => 'error', 'message' => 'Invalid password.'];
            }
        }else{
            return ['status' => 'error', 'message' => 'Please create your account to continue.'];
        }

    }


    /**
     * @param $user
     * @param string $redirectTo
     */
    public function setUserSession($user,$redirectTo = '')
    {
        if (is_object($user)) {
            $_SESSION['userId'] = $user->id;
            $_SESSION['username'] = $user->username;
            $_SESSION['email'] = $user->email;
            $_SESSION['referral_id'] = $user->referral_id;
        }
        if (!empty($redirectTo)){
            header("location:".$redirectTo);
        }
    }

    /**
     * @param int $userId
     * @return string
     */
    public static function getUserid($userId = 0)
    {
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT id FROM users where id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->id;
        }else{
            return 'Anonymous';
        }
    }

/**
     * @param int $userId
     * @return string
     */
    public static function getUsername($userId = 0)
    {
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT username FROM users where id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->username;
        }else{
            return 'Anonymous';
        }
    }


    /**
     * @param int $userId
     * @return string
     */
    public static function getUserRefferalLink($userId = 0)
    {
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
      $sql = "SELECT confirm FROM users where id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
          $row = $result->fetch_object();
        $confirm = $row->confirm;
        if($confirm == 1){
             $sql2 = "SELECT referral_id FROM users where id='" . $userId. "'";
        $result2 = $self->getConnection()->query($sql2);
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_object();
            return $self->getUrl().'/signup.php?refl='.$row2->referral_id;
        }
        }else{
            return 'LOCKED';
        }
       
    }
     public static function getUserRefferalLink2($userId = 0)
    {
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
      $sql = "SELECT confirm2 FROM users where id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
          $row = $result->fetch_object();
        $confirm = $row->confirm2;
        if($confirm == 0){
             $sql2 = "SELECT ref_id2 FROM users where id='" . $userId. "'";
        $result2 = $self->getConnection()->query($sql2);
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_object();
            return $self->getUrl().'/signup.php?refl2='.$row2->ref_id2;
        }
        }else{
            return 'LOCKED';
        }
       
    }
    public static function getUserRefferalLink3($userId = 0)
    {
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
      $sql = "SELECT confirm3 FROM users where id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
          $row = $result->fetch_object();
        $confirm = $row->confirm3;
        if($confirm == 0){
             $sql2 = "SELECT ref_id3 FROM users where id='" . $userId. "'";
        $result2 = $self->getConnection()->query($sql2);
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_object();
            return $self->getUrl().'/signup.php?refl3='.$row2->ref_id3;
        }
        }else{
            return 'LOCKED';
        }
       
    }
    public static function getUserRefferalLink4($userId = 0)
    {
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
      $sql = "SELECT confirm4 FROM users where id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
          $row = $result->fetch_object();
        $confirm = $row->confirm4;
        if($confirm == 0){
             $sql2 = "SELECT ref_id4 FROM users where id='" . $userId. "'";
        $result2 = $self->getConnection()->query($sql2);
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_object();
            return $self->getUrl().'/signup.php?refl4='.$row2->ref_id4;
        }
        }else{
            return 'LOCKED';
        }
       
    }
    public static function getemail($userId = 0)
    {
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT email FROM users where id='$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{email};
        }else{
            return 'not found';
        }
    }

    /**
     * @param int $userId
     * @return int
     */
    public static function getUserBalance($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT SUM(ub.adjusted_amout) as userTotalBalance FROM `users` u left join user_balance ub on u.id = ub.user_id where u.id ='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->userTotalBalance > 0 ? $row->userTotalBalance :0;
        }else{
            return 0;
        }
    }
    
       public static function getUserBtcx($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT my_btcx FROM users where id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{my_btcx};
        }else{
            return 0;
        }
    }
    
          public static function getUserBTCwallet($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT BTC_Wallet FROM users where id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{BTC_Wallet};
        }else{
            return 0;
        }
    }
    
      public static function getUserETHERwallet($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT ETHER_Wallet FROM users where id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{ETHER_Wallet};
        }
        else{
            return 0;
        }
    }
    
     public static function getrefbysliver($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT referred_to FROM user_referrals where user_id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{referred_by};
        }
        else{
            return 0;
        }
    }
     public static function getrefbygold($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT ref_by FROM gold where user_id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{ref_by};
        }
        else{
            return 0;
        }
    }
    
    public static function getrefbyplat($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT ref_by FROM platinum where user_id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{ref_by};
        }
        else{
            return 0;
        }
    }
    
     public static function getrefbydaim($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT ref_by FROM daimond where user_id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{ref_by};
        }
        else{
            return 0;
        }
    }
    
    
     public static function getUserBtcxandreferal($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT my_btcx FROM users where id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            $btcx =  $row->{my_btcx};
        }
        
        
         $sql2 = "SELECT SUM(ub.adjusted_amout) as userTotalBalance FROM `users` u left join user_balance ub on u.id = ub.user_id where u.id ='" . $userId. "'";
        $result2 = $self->getConnection()->query($sql2);
        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_object();
            $referal =  $row2->userTotalBalance;
        }
        
          $sql3 = "SELECT SUM(g.adjusted_amout) as userfullBalance FROM `users` u left join gold g on u.id = g.ref_by where u.id ='" . $userId. "'";
        $result3 = $self->getConnection()->query($sql3);
        if ($result3->num_rows > 0) {
            $row3 = $result3->fetch_object();
            $referal2 =  $row3->userfullBalance;
        }
        
         $sql4 = "SELECT SUM(p.adjust_amount) as userfulBalance FROM `users` u left join platinum p on u.id = p.ref_by where u.id ='" . $userId. "'";
        $result4 = $self->getConnection()->query($sql4);
        if ($result4->num_rows > 0) {
            $row4 = $result4->fetch_object();
            $referal3 =  $row4->userfulBalance;
        }
        
         $sql5 = "SELECT SUM(d.adjust_amount) as userfllBalance FROM `users` u left join daimond d on u.id = d.ref_by where u.id ='" . $userId. "'";
        $result5 = $self->getConnection()->query($sql5);
        if ($result5->num_rows > 0) {
            $row5 = $result5->fetch_object();
            $referal4 =  $row5->userfllBalance;
        }
        
        $total = $btcx+$referal+$referal2+$referal3+$referal4;
        return $total;
    }
    

    
    
    
    public static function getUserBTC($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT BTC FROM users where id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{BTC};
        }else{
            return 0;
        }
    }
    
    
    public static function getUserETH($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT ETH FROM users where id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{ETH};
        }else{
            return 0;
        }
    }
    
     public static function getUserLTC($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT LTC FROM users where id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            return $row->{LTC};
        }else{
            return 0;
        }
    }
             /* TRICK*/
             
       public static function getUserUSD($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT usd FROM user_balance where user_id = '$userId'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            $row = $result->fetch_object();
            $usd = $row->{USD};
        }
        
          $sql1 = "SELECT confirm FROM user_balance where user_id='" . $userId. "'";
        $result = $self->getConnection()->query($sql1);
          $row = $result->fetch_object();
        $confirm = $row->confirm;
        if($confirm==1){
        
         $sql6 = "SELECT SUM(b.usd) as userfullusd FROM `users` u left join user_balance b on u.id = b.user_id where u.id ='" . $userId. "'";
        $result6 = $self->getConnection()->query($sql6);
       
        if ($result6->num_rows > 0) {
            $row6 = $result6->fetch_object();
            $referal1 =  $row6->userfullusd;
        }
        }
       
          
        $sqlgold = "SELECT confirm2 FROM gold where user_id='" . $userId. "'";
        $result = $self->getConnection()->query($sqlgold);
          $row = $result->fetch_object();
        $confirm2 = $row->confirm2;
        if($confirm2 == 1){
          $sql3 = "SELECT SUM(g.usd) as userfullusd FROM `users` u left join gold g on u.id = g.ref_by where u.id ='" . $userId. "'";
        $result3 = $self->getConnection()->query($sql3);
        if ($result3->num_rows > 0) {
            $row3 = $result3->fetch_object();
            $referal2 =  $row3->userfullusd;
        }
        }else{
            $referal2 = '';
        }
         $sql = "SELECT confirm3 FROM platinum where user_id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
          $row = $result->fetch_object();
        $confirm3 = $row->confirm3;
        if($confirm3 == 1){
            
         $sql4 = "SELECT SUM(p.usd) as userfulBalance FROM `users` u left join platinum p on u.id = p.ref_by where u.id ='" . $userId. "'";
        $result4 = $self->getConnection()->query($sql4);
        
        if ($result4->num_rows > 0) {
            $row4 = $result4->fetch_object();
            $referal3 =  $row4->userfulBalance;
        }
        }
         $sql = "SELECT confirm4 FROM daimond where user_id='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
          $row = $result->fetch_object();
        $confirm4 = $row->confirm4;
        if($confirm4 == 1){
        
         $sql5 = "SELECT SUM(d.usd) as userfllBalance FROM `users` u left join daimond d on u.id = d.ref_by where u.id ='" . $userId. "'";
        $result5 = $self->getConnection()->query($sql5);
        
        if ($result5->num_rows > 0) {
            $row5 = $result5->fetch_object();
            $referal4 =  $row5->userfllBalance;
        }
        }
        
        $total = $referal1+$referal2+$referal3+$referal4;
        return $total;
        
        
    }

    /**
     * @param int $userId
     * @return null|object|stdClass
     */
    public static function getUserReferrals($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT u.*,ur.created_at as referred_at FROM `users` u left join user_referrals ur on u.id = ur.user_id where ur.referred_by ='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return $result;

        }else{
            return null;
        }
        
    }
    
    public static function getUserReferralsgold($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT u.*,g.created_at as referred_at FROM `users` u left join gold g on u.id = g.user_id where g.ref_by ='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return $result;

        }else{
            return null;
        }
        
    }
      public static function getUserReferralsplat($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT u.*,p.created_at as referred_at FROM `users` u left join platinum p on u.id = p.user_id where p.ref_by ='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return $result;

        }else{
            return null;
        }
        
    }
    
    public static function getUserReferralsdaim($userId = 0){
        $self = new self();
        $userId = $userId > 0 ? $userId:$_SESSION['userId'];
        $userId = $self->escapeString($userId);
        $sql = "SELECT u.*,d.created_at as referred_at FROM `users` u left join daimond d on u.id = d.user_id where d.ref_by ='" . $userId. "'";
        $result = $self->getConnection()->query($sql);
        if ($result->num_rows > 0) {
            return $result;

        }else{
            return null;
        }
        
    }
    
    
    public function sendemail(){
          
        }
    
    
}