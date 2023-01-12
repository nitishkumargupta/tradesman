<?php
class User
{
  private $firstName;
  private $lastName;

  private $type;

  private $active;

  private $registrationDate;

  private $email;

  private $pass;

  private $phoneNumber;
  private $dbc;

  public function __construct($email, $dbc)
  {
    $this->email = $email;
    $this->active = True; // Default status of user
    $this->dbc = $dbc;
  }

  function getFirstName()
  {
    return $this->firstName;
  }

  function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  function getLastName()
  {
    return $this->lastName;
  }

  function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }

  function getType()
  {
    return $this->type;
  }

  function setType($type)
  {
    $this->type = $type;
  }

  function getActive()
  {
    return $this->active;
  }

  function setActive($active)
  {
    $this->active = $active;
  }

  function getRegistrationDate()
  {
    return $this->registrationDate;
  }

  function setRegistrationDate($registrationDate)
  {
    $this->registrationDate = $registrationDate;
  }

  function getEmail()
  {
    return $this->email;
  }

  function setEmail($email)
  {
    $this->email = $email;
  }

  function setPass($pass)
  {
    $this->pass = $pass;
  }

  function getPhoneNumber()
  {
    return $this->phoneNumber;
  }

  function setPhoneNumber($phoneNumber)
  {
    $this->phoneNumber = $phoneNumber;
  }

  public function registerUser()
  {
    try {
      if ($this->userExists()) {
        return array('success' => false, 'message' => 'Email address already registered.');
      }
      $query = "INSERT INTO users (first_name, last_name, email, phone_no, pass, type, active) VALUES ('$this->firstName', '$this->lastName', '$this->email', '$this->phoneNumber', SHA1('$this->pass'),'$this->type','$this->active' )";
      $result = $this->dbc->query($query);
      if ($result) {
        return array('success' => true, 'message' => 'You are now registered');
      } else {
        return array('success' => false, 'message' => 'Internal Server Error');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

  public function updateUser()
  {
    try {
      $query = "UPDATE users set first_name = '$this->firstName', last_name = '$this->lastName' where email = '$this->email'";
      $result = $this->dbc->query($query);
      if ($result) {
        return array('success' => true, 'message' => 'User Updated');
      } else {
        return array('success' => false, 'message' => 'Internal Server Error');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

  public function userExists()
  {
    $query = "SELECT * FROM users WHERE email='$this->email'";
    $result = $this->dbc->query($query);
    $rowcount = $result->num_rows;
    if ($rowcount != 0) {
      return true;
    }
    return false;
  }

  public function resetPassword()
  {
    if (!$this->userExists()) {
      return array('success' => false, 'message' => 'No user account found');
    }
    try {
      $query = "UPDATE users set pass = SHA1('$this->pass') where email = '$this->email'";
      $result = $this->dbc->query($query);
      if ($result) {
        return array('success' => true, 'message' => 'Password updated!');
      } else {
        return array('success' => false, 'message' => 'Internal Server Error');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

}

class Trademan extends User
{
  private $dbc;
  private $tradesman_id;
  private $firstName;
  private $lastName;
  private $hourly_rate;
  private $is_professional;
  private $registered_with;
  private $bio;

  private $past_experience;

  public function __construct($tradesmanId, $dbc)
  {
    $this->tradesman_id = $tradesmanId;
    $this->dbc = $dbc;
  }

  function getFirstName()
  {
    return $this->firstName;
  }

  function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  function getLastName()
  {
    return $this->lastName;
  }

  function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }

  function getBio()
  {
    return $this->bio;
  }

  function setBio($bio)
  {
    $this->bio = $bio;
  }
  function getHourlyRate()
  {
    return $this->hourly_rate;
  }
  function setHourlyRate($HourlyRate)
  {
    $this->hourly_rate = $HourlyRate;
  }

  function getIsProfessional()
  {
    return $this->is_professional;
  }

  function setIsProfessional($IsProfessional)
  {
    $this->is_professional = $IsProfessional;
  }

  function getRegisteredWith()
  {
    return $this->registered_with;
  }

  function setRegisteredWith($registered_with)
  {
    $this->registered_with = $registered_with;
  }

  function getPastExperience()
  {
    return $this->past_experience;
  }

  function setPastExperience($past_experience)
  {
    $this->past_experience = $past_experience;
  }
  public function getTrademan()
  {
    try {
      $query = "SELECT * FROM users WHERE user_id='$this->tradesman_id'";
      $result = $this->dbc->query($query);
      if ($result) {
        return array('success' => true, 'data' => $result);
      } else {
        return array('success' => false, 'message' => 'No Data Found');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

  public function updateUser()
  {
    try {
      $query = "UPDATE users set first_name = '$this->firstName', last_name = '$this->lastName', bio = '$this->bio', hourly_rate = '$this->hourly_rate', is_professional = '$this->is_professional', past_experience = '$this->past_experience', bio = '$this->bio', registered_with = '$this->registered_with' where user_id = '$this->tradesman_id'";
      $result = $this->dbc->query($query);
      if ($result) {
        return array('success' => true, 'message' => 'User Updated');
      } else {
        return array('success' => false, 'message' => 'Internal Server Error');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }
}

class Customer extends User
{
  private $dbc;
  private $user_id;
  private $firstName;
  private $lastName;
  private $bio;

  function getFirstName()
  {
    return $this->firstName;
  }

  function setFirstName($firstName)
  {
    $this->firstName = $firstName;
  }

  function getLastName()
  {
    return $this->lastName;
  }

  function setLastName($lastName)
  {
    $this->lastName = $lastName;
  }

  function getBio()
  {
    return $this->bio;
  }

  function setBio($bio)
  {
    $this->bio = $bio;
  }


  public function __construct($userId, $dbc)
  {
    $this->user_id = $userId;
    $this->dbc = $dbc;
  }
  public function getCustomer()
  {
    try {
      $query = "SELECT * FROM users WHERE user_id='$this->user_id'";
      $result = $this->dbc->query($query);
      if ($result) {
        return array('success' => true, 'data' => $result);
      } else {
        return array('success' => false, 'message' => 'No Data Found');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }

  public function updateUser()
  {
    try {
      $query = "UPDATE users set first_name = '$this->firstName', last_name = '$this->lastName', bio = '$this->bio' where user_id = '$this->user_id'";
      $result = $this->dbc->query($query);
      if ($result) {
        return array('success' => true, 'message' => 'User Updated');
      } else {
        return array('success' => false, 'message' => 'Internal Server Error');
      }
    } catch (Exception $e) {
      return array('success' => false, 'message' => 'Internal Server Error');
    }
  }
}
?>