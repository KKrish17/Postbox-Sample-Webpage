<?php
/**
 * Stores the details of a particular user
 * 
 * Copyright (c)  2013-2015 Codedodle.com
 * 
 * @author Tamil Selvan K <info@codedodle.com>
 */
class User {
  
  /**
   * The Unique id of the user
   *
   * @var Int
   */
  private $userId;
  
  /**
   * Name of the user
   *
   * @var String
   */
  private $userName;
  
  /**
   * User email id
   *
   * @var String
   */
  private $email;
  
  /**
   * User password
   *
   * @var String
   */
  private $password;
  
  //##################### Accessor and Mutator Methods #########################
  
  public function getUserId() {
    return $this->userId;
  }
  
  public function setUserId($userId) {
    $this->userId = $userId;
  }
  
  public function getUsername() {
    return $this->userName;
  }
  
  public function setUsername($userName) {
    $this->userName = $userName;
  }
  
  public function getEmail() {
    return $this->email;
  }
  
  public function setEmail($email) {
    $this->email = $email;
  }
  
  public function getPassword() {
    return $this->password;
  }
  
  public function setPassword($password) {
    $this->password = $password;
  }
  
  //##################### End of Accessor and Mutator Methods ##################
  
  /**
   * Returns the User Object provided the id of the user.
   * 
   * @param mysqli $db
   * @param int $id
   * @return \User
   */
  public function getUser($db, $id) {
    $resultObj = $db->query('SELECT * FROM `users` ' . 
                'WHERE `users`.`ID` = ' . (int) $id);
    $user_details = $resultObj->fetch_assoc();
    $user = new User();
    $user->arrToUser($user_details);
    return $user;
  }
  
  /**
   * Set's the user details returned from the query into the current object.
   * 
   * @param array $userRow
   */
  public function arrToUser($userRow) {
    if (!empty($userRow)) {
      isset($userRow['ID']) ? 
        $this->setUserId($userRow['ID']) : '';
      isset($userRow['first']) ? 
        $this->setUsername($userRow['first']) : '';
      isset($userRow['email']) ? 
        $this->setEmail($userRow['email']) : '';
      isset($userRow['password']) ? 
        $this->setPassword($userRow['password']) : '';
    }
  }
}