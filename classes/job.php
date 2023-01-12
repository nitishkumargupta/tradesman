<?php
class Job
{
  private $job_title;
  private $cat_id;

  private $status;

  private $date_created;

  private $date_executed;
  private $customer_id;
  private $tradesman_id;
  private $pin;
  private $description;
  private $booked_from;
  private $booked_to;

  private $dbc;

  public function __construct($tradesmanId, $customerId, $dbc)
  {
    $this->tradesman_id = $tradesmanId;
    $this->customer_id = $customerId;
    $this->dbc = $dbc;
  }

  function getJobTitle()
  {
    return $this->job_title;
  }

  function setJobTitle($JobTitle)
  {
    $this->job_title = $JobTitle;
  }

  function getCatId()
  {
    return $this->cat_id;
  }

  function setCatId($CatId)
  {
    $this->cat_id = $CatId;
  }

  function getstatus()
  {
    return $this->status;
  }

  function setStatus($status)
  {
    $this->status = $status;
  }

  function getDateCreated()
  {
    return $this->date_created;
  }

  function setDateCreated($DateCreated)
  {
    $this->date_created = $DateCreated;
  }

  function getDateExecuted()
  {
    return $this->date_executed;
  }

  function setDateExecuted($DateExecuted)
  {
    $this->date_executed = $DateExecuted;
  }

  function getCustomerId()
  {
    return $this->customer_id;
  }

  function setCustomerId($customerId)
  {
    $this->customer_id = $customerId;
  }

  function getTradesmanId()
  {
    return $this->tradesman_id;
  }

  function setTradesmanId($tradesmanId)
  {
    $this->tradesman_id = $tradesmanId;
  }

  function getPin()
  {
    return $this->pin;
  }

  function setPin($pin)
  {
    $this->pin = $pin;
  }

  function getDescription()
  {
    return $this->description;
  }

  function setDescription($description)
  {
    $this->description = $description;
  }

  function getBookedFrom()
  {
    return $this->booked_from;
  }

  function setBookedFrom($bookedFrom)
  {
    $this->booked_from = $bookedFrom;
  }

  function getBookedTo()
  {
    return $this->booked_to;
  }

  function setBookedTo($bookedTo)
  {
    $this->booked_to = $bookedTo;
  }

  public function getJobs($attribute, $value)
  {
    try {
      $q = "SELECT * from jobs where $attribute = '$value'";
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

  public function getJob($attribute, $value)
  {
    try {
      $q = "SELECT * from jobs where $attribute = '$value'";
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