<?php

    namespace BackendBundle\Entity;
    use Doctrine\Common\Collections\ArrayCollection;
class MedicalHistoryDoc {
/* id *********************************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* doc ********************************************************************************************************/
	private $doc;
    public function setDoc($doc) { $this->doc = $doc; return $this; }
    public function getDoc() { return $this->doc; }
/**************************************************************************************************************/
/* title ******************************************************************************************************/
    private $title;
    public function setTitle($title) { $this->title = $title; return $this; }
    public function getTitle() { return $this->title; }
/**************************************************************************************************************/
/* description ************************************************************************************************/
	private $description;
    public function setDescription($description) { $this->description = $description; return $this; }
    public function getDescription() { return $this->description; }
/**************************************************************************************************************/
/* typeDoc *******************************************************************************************/
    private $typeDoc;
    public function setTypeDoc(\BackendBundle\Entity\TypeDoc $type = null) { $this->typeDoc = $type; return $this; }
    public function getTypeDoc() { return $this->typeDoc; }
/**************************************************************************************************************/
/* registrationDate *******************************************************************************************/
    private $registrationDate;
    public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; }
    public function getRegistrationDate() { return $this->registrationDate; }
/**************************************************************************************************************/
/* idUserRegisterer *******************************************************************************************/
    private $userRegisterer;
    public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null) { $this->userRegisterer = $userRegisterer; return $this; }
    public function getUserRegisterer() { return $this->userRegisterer; }
/**************************************************************************************************************/
/* modificationDate *******************************************************************************************/
    private $modificationDate;
    public function setModificationDate($modificationDate) { $this->modificationDate = $modificationDate; return $this; }
    public function getModificationDate() { return $this->modificationDate; }
/**************************************************************************************************************/
/* numberMedicalHistory ***************************************************************************************/
    private $userModifier;
    public function setUserModifier(\BackendBundle\Entity\User $userModifier = null) { $this->userModifier = $userModifier; return $this; }
    public function getUserModifier() { return $this->userModifier; }
/**************************************************************************************************************/
/* idMedicalHistory *******************************************************************************************/
    private $medicalHistory;
    public function setMedicalHistory(\BackendBundle\Entity\MedicalHistory $medicalHistory = null) { $this->medicalHistory = $medicalHistory; return $this; }
    public function getMedicalHistory() { return $this->medicalHistory; }
/**************************************************************************************************************/
}
