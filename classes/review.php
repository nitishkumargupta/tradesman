<?php
class Review
{
  private $comment;
  private $rate;

  private $job_id;

  private $tradesman_id;

  private $customer_id;

  private $dbc;

  public function __construct($tradesmanId, $dbc)
  {
    $this->tradesman_id = $tradesmanId;
    $this->dbc = $dbc;
  }

  function getComent()
  {
    return $this->comment;
  }

  function setComment($comment)
  {
    $this->comment = $comment;
  }

  function getRate()
  {
    return $this->rate;
  }

  function setRate($rate)
  {
    $this->rate = $rate;
  }

  function getJobId()
  {
    return $this->job_id;
  }

  function setJobId($jobId)
  {
    $this->job_id = $jobId;
  }

  function getTradesmanId()
  {
    return $this->tradesman_id;
  }

  function setTradesmanId($tradesmanId)
  {
    $this->tradesman_id = $tradesmanId;
  }

  function getCustomerId()
  {
    return $this->customer_id;
  }

  function setCustomerId($customerId)
  {
    $this->customer_id = $customerId;
  }

  public function getCount()
  {
    try {
      $q = "SELECT IFNULL(count(*),0) as count from review where tradesman_id = '$this->tradesman_id'";
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
  public function getAverage()
  {
    try {
      $q = "SELECT IFNULL(avg(rate),0) as avg from review where tradesman_id = '$this->tradesman_id'";
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

  public function getReviews()
  {
    try {
      $q = "SELECT * from review where tradesman_id = '$this->tradesman_id'";
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