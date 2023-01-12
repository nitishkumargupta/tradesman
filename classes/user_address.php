<?php
class UserAddress
{
  private $post_code;
  private $line_1;
  private $line_2;
  private $city;
  private $user_id;
  private $dbc;

  public function __construct($userId, $dbc)
  {
    $this->user_id = $userId;
    $this->dbc = $dbc;
  }

  function getPostCode()
  {
    return $this->post_code;
  }

  function setPostCode($postCode)
  {
    $this->post_code = $postCode;
  }

  function getUserId()
  {
    return $this->user_id;
  }

  function setUserId($userId)
  {
    $this->user_id = $userId;
  }

  function getLine1()
  {
    return $this->line_1;
  }

  function setLine1($line1)
  {
    $this->line_1 = $line1;
  }

  function getLine2()
  {
    return $this->line_2;
  }

  function setLine2($line2)
  {
    $this->line_2 = $line2;
  }

  function getCity()
  {
    return $this->city;
  }

  function setCity($city)
  {
    $this->city = $city;
  }

  public function getUserAddress()
  {
    try {
      $q = "SELECT * from us_address where user_id = '$this->user_id'";
      $result = $this->dbc->query($q);
      $rowCount = $result->num_rows;
      if ($rowCount) {
        return array('success' => true, 'data' => $result);
      } else {
        return array('success' => false, 'message' => 'No Data Found');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

  public function setAddress()
  {
    try {
      $q = "INSERT into us_address (post_code, line_1,line_2, city, user_id) values ('$this->post_code','$this->line_1','$this->line_2','$this->city', '$this->user_id')";
      $result = $this->dbc->query($q);
      if ($result) {
        return array('success' => true, 'data' => $result);
      } else {
        return array('success' => false, 'message' => 'No Data Found');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

  public function updateAddress()
  {
    try {
      $q = "UPDATE us_address set post_code = '$this->post_code', line_1 = '$this->line_1', line_2 = '$this->line_2', city = '$this->city' where user_id = '$this->user_id'";
      $result = $this->dbc->query($q);
      if ($this->dbc->affected_rows == 0) {
        $this->setAddress();
        return array('success' => true, 'data' => $result);
      }
      if ($result) {
        return array('success' => true, 'data' => $result);
      } else {
        return array('success' => false, 'message' => 'No Data Found');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

}
?>