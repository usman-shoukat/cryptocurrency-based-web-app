
  <?php
  class User extends Database
{
     public function jazzcash()
    {
          if (empty($_POST['username'])) {
            return ['status' => 'error', 'message' => 'Full name field is required.'];
        }
        if (empty($_POST['jazzcashno'])) {
            return ['status' => 'error', 'message' => 'Your jazzcash number required.'];
        }
        if (empty($_POST['amount'])) {
            return ['status' => 'error', 'message' => 'Your withdrawal amount required.'];
        }
         $username = $_POST['username'];
         $jazzcashno = $_POST['jazzcashno']; 
         $amount = $_POST['amount'];
         
    $sql = "SELECT * FROM users where user_id = '" . $_SESSION['userId'] . "'";
            $result = $this->getConnection()->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_object();
                $sql = "INSERT INTO jazzcash (`user_id`, `username`, `email`, `jazzcashno`,`amount`,`paymethod`) VALUES ('" . $row->id . "','" . $row->email . "','" . $jazzcashno . "','" . $amount . "',jazzcash)";
                $this->getConnection()->query($sql);
    }
}
}
?>