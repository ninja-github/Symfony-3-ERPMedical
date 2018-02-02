<?php

namespace BackendBundle\Entity;

/**
 * UserDataDoctor
 */
class UserDataDoctor { 
    private $id; 
    private $collegeNumber; 
    private $user; 
    public function getId() { return $this->id; } 
    public function setCollegeNumber($collegeNumber) { $this->collegeNumber = $collegeNumber; return $this; } 
    public function getCollegeNumber() { return $this->collegeNumber; } 
    public function setUser(\BackendBundle\Entity\User $user = null) { $this->user = $user; return $this; } 
    public function getUser() { return $this->user; }
}
