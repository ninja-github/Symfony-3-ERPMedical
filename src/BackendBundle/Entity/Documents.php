<?php

    namespace BackendBundle\Entity;
    use Doctrine\Common\Collections\ArrayCollection;
class Documents {
/* id *********************************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* clinic *****************************************************************************************************/
	private $clinic;
	public function setClinic(\BackendBundle\Entity\Clinic $clinic = null) { $this->clinic = $clinic; return $this; }
	public function getClinic() { return $this->clinic; }
/**************************************************************************************************************/
/* business ***************************************************************************************************/
	private $business;
	public function setBusiness(\BackendBundle\Entity\Business $business = null) { $this->business = $business; return $this; }
	public function getBusiness() { return $this->business; }
/**************************************************************************************************************/
/* medicalHistory *********************************************************************************************/
	private $medicalHistory;
	public function setMedicalHistory(\BackendBundle\Entity\MedicalHistory $medicalHistory = null) { $this->medicalHistory = $medicalHistory; return $this; }
	public function getMedicalHistory() { return $this->medicalHistory; }
/**************************************************************************************************************/
/* orthopodologyHistory ***************************************************************************************/
	private $orthopodologyHistory;
	public function setOrthopodologyHistory(\BackendBundle\Entity\OrthopodologyHistory $orthopodologyHistory = null) { $this->orthopodologyHistory = $orthopodologyHistory; return $this; }
	public function getOrthopodologyHistory() { return $this->orthopodologyHistory; }
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
/* typeContentDoc *******************************************************************************************/
    private $typeContentDoc;
    public function setTypeContentDoc(\BackendBundle\Entity\TypeContentDoc $type = null) { $this->typeContentDoc = $type; return $this; }
    public function getTypeContentDoc() { return $this->typeContentDoc; }
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
}