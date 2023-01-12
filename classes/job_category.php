<?php
class JobCategory
{
  private $cat_name;
  private $dbc;

  public function __construct($catName, $dbc)
  {
    $this->cat_name = $catName;
    $this->dbc = $dbc;
  }

  function getCatName()
  {
    return $this->cat_name;
  }

  function setCatName($catName)
  {
    $this->cat_name = $catName;
  }

  public function getCategory($catId)
  {
    try {
      $q = "SELECT * from job_category where cat_id = '$catId'";
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
  public function getCategories()
  {
    try {
      $q = "SELECT * from job_category";
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

}
?>