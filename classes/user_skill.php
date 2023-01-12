<?php
class UserSkill
{
  private $cat_id;
  private $user_id;
  private $dbc;

  public function __construct($userId, $dbc)
  {
    $this->user_id = $userId;
    $this->dbc = $dbc;
  }

  function getCatId()
  {
    return $this->cat_id;
  }

  function setCatId($catId)
  {
    $this->cat_id = $catId;
  }

  function getUserId()
  {
    return $this->user_id;
  }

  function setUserId($userId)
  {
    $this->user_id = $userId;
  }

  public function getUserSkills()
  {
    try {
      $q = "SELECT * from us_skill where tradesman_id = '$this->user_id'";
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
  public function setSkill($skillName, $skillId)
  {
    try {
      $q = "INSERT into us_skill (cat_id,tradesman_id,skill) values ('$skillId','$this->user_id','$skillName')";
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

  public function removeSkills()
  {
    try {
      $q = "DELETE from us_skill where tradesman_id = $this->user_id";
      $result = $this->dbc->query($q);
      if ($result) {
        return true;
      } else {
        return false;
      }
    } catch (Exception $e) {
      return false;
    }
  }

}
?>