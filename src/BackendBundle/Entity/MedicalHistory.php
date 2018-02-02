<?php
/* Namespace **************************************************************************************************/
	namespace BackendBundle\Entity;
/* Añadimos el VALIDADOR **************************************************************************************/
/*
 * Definimos el sistema de validación de los datos en las entidades dentro de "app\config\config.yml"
 * y la gestionamos en "src\AppBundle\Resources\config\validation.yml",
 * cada entidad deberá llamar a "use Symfony\Component\Validator\Constraints as Assert;"
 * VER src\BackendBundle\Entity\User.php
 */
	use Symfony\Component\Validator\Constraints as Assert;
	use Doctrine\Common\Collections\ArrayCollection;
/**************************************************************************************************************/
class MedicalHistory {
/* Variable contiene un string con todos los datos del paciente ***********************************************/
/* Se mostrará al usar esta variable 'MedicalHistory' */
	private $medicalHistoryDataComplete;
	public function getMedicalHistoryDataComplete() { return (string)$this->medicalHistoryNumber.' - '.$this->name.' '.$this->surname; }
/**************************************************************************************************************/
/* Listamos Documentos asociados a la Historia Médica *********************************************************/
	private $docList;
	public function getDocList() { return $this->docList; }
	public function addDocList(\BackendBundle\Entity\MedicalHistoryDoc $docList) { $this->docList[] = $docList; return $this; } 
	public function removeDocList(\BackendBundle\Entity\MedicalHistoryDoc $docList) { $this->docList->removeElement($docList); } 	
/**************************************************************************************************************/
/* Listamos Seguimientos asociados a la Historia Médica *******************************************************/
	private $tracingList;
	public function getTracingList() { return $this->tracingList; }
	public function addTracingList(\BackendBundle\Entity\Tracing $tracingList) { $this->tracingList[] = $tracingList; return $this; } 
	public function removeTracingList(\BackendBundle\Entity\Tracing $tracingList) { $this->tracingList->removeElement($tracingList); } 
/**************************************************************************************************************/
/* Listamos Estudios Orthopodológicos asociados a la Historia Médica ******************************************/
	private $orthopodologyHistoryList;
	public function getOrthopodologyHistoryList() { return $this->orthopodologyHistoryList; }
	public function addOrthopodologyHistoryList(\BackendBundle\Entity\OrthopodologyHistory $orthopodologyHistoryList) { $this->orthopodologyHistoryList[] = $orthopodologyHistoryList; return $this; }
	public function removeOrthopodologyHistoryList(\BackendBundle\Entity\OrthopodologyHistory $orthopodologyHistoryList) { $this->orthopodologyHistoryList->removeElement($orthopodologyHistoryList); }	
/**************************************************************************************************************/
/* CONSTRUCTOR ************************************************************************************************/
	//Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
	public function __construct() {
		$this->medicalHistoryDataComplete = new ArrayCollection();
		$this->docList = new ArrayCollection();
		$this->tracingList = new ArrayCollection();
		$this->orthopodologyHistoryList = new ArrayCollection();
    }
/**************************************************************************************************************/
	//la función __toString(){ return $this->gender;  } permite listar los campos cuando referenciemos la tabla
    public function __toString(){ return (string)$this->medicalHistoryNumber.' - '.$this->name.' '.$this->surname; }
/**************************************************************************************************************/
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* medicalHistoryNumber ***************************************************************************************/
	private $medicalHistoryNumber;
	public function setMedicalHistoryNumber($medicalHistoryNumber) { $this->medicalHistoryNumber = $medicalHistoryNumber; return $this; }
	public function getMedicalHistoryNumber() { return $this->medicalHistoryNumber; }
/**************************************************************************************************************/
/* name *******************************************************************************************************/
	private $name;
	public function setName($name) { $this->name = $name; return $this; }
	public function getName() { return $this->name; }
/**************************************************************************************************************/
/* surname ****************************************************************************************************/
	private $surname;
	public function setSurname($surname) { $this->surname = $surname; return $this; }
	public function getSurname() { return $this->surname; }
/**************************************************************************************************************/
/* nickname ***************************************************************************************************/
	private $nickname;
	public function setNickname($nickname) { $this->nickname = $nickname; return $this; }
	public function getNickname() { return $this->nickname; }
/**************************************************************************************************************/
/* dni ********************************************************************************************************/
	private $dni;
	public function setDni($dni) { $this->dni = $dni; return $this; }
	public function getDni() { return $this->dni; }
/**************************************************************************************************************/
/* phoneHome **************************************************************************************************/
	private $phoneHome;
	public function setPhoneHome($phoneHome) { $this->phoneHome = $phoneHome; return $this; }
	public function getPhoneHome() { return $this->phoneHome; }
/**************************************************************************************************************/
/* phoneMobile ************************************************************************************************/
	private $phoneMobile;
	public function setPhoneMobile($phoneMobile) { $this->phoneMobile = $phoneMobile; return $this; }
	public function getPhoneMobile() { return $this->phoneMobile; }
/**************************************************************************************************************/
/* email ******************************************************************************************************/
	private $email;
	public function setEmail($email) { $this->email = $email; return $this; }
	public function getEmail() { return $this->email; }
/**************************************************************************************************************/
/* address ****************************************************************************************************/
	private $address;
	public function setAddress($address) { $this->address = $address; return $this; }
	public function getAddress() { return $this->address; }
/**************************************************************************************************************/
/* birthday ***************************************************************************************************/
	private $birthday;
	public function setBirthday($birthday) { $this->birthday = $birthday; return $this; }
	public function getBirthday() { return $this->birthday; }
/**************************************************************************************************************/
/* gender *****************************************************************************************************/
	private $gender;
    public function setGender(\BackendBundle\Entity\TypeGender $type = null) { $this->gender = $type; return $this; }
    public function getGender() { return $this->gender; }
/**************************************************************************************************************/
/* city *******************************************************************************************************/
	private $city;
    public function setCity(\BackendBundle\Entity\AddressCity $city = null) { $this->city = $city; return $this; }
    public function getCity() { return $this->city; }
/**************************************************************************************************************/
/* height *****************************************************************************************************/
	private $height;
    public function setHeight($height) { $this->height = $height; return $this; }
    public function getHeight() { return $this->height; }
/**************************************************************************************************************/
/* weight *****************************************************************************************************/
	private $weight;
	public function setWeight($weight) { $this->weight = $weight; return $this; }
	public function getWeight() { return $this->weight; }
/**************************************************************************************************************/
/* note ***************************************************************************************/
	private $note;
	public function setNote($note) { $this->note = $note; return $this; }
	public function getNote() { return $this->note; }
/**************************************************************************************************************/
/* reasonConsultation ***************************************************************************************/
	private $reasonConsultation;
	public function setReasonConsultation($reasonConsultation) { $this->reasonConsultation = $reasonConsultation; return $this; }
	public function getReasonConsultation() { return $this->reasonConsultation; }
/**************************************************************************************************************/
/* background *************************************************************************************************/
	private $background;
	public function setBackground($background) { $this->background = $background; return $this; }
	public function getBackground() { return $this->background; }
/**************************************************************************************************************/
/* patientRisk ************************************************************************************************/
	private $patientRisk;
	public function setPatientRisk($patientRisk) { $this->patientRisk = $patientRisk; return $this; }
	public function getPatientRisk() { return $this->patientRisk; }
/**************************************************************************************************************/
/* allergicDiseases *******************************************************************************************/
	private $allergicDiseases;
	public function setAllergicDiseases($allergicDiseases) { $this->allergicDiseases = $allergicDiseases; return $this; }
	public function getAllergicDiseases() { return $this->allergicDiseases; }
/**************************************************************************************************************/
/* treatmentDiseases ******************************************************************************************/
	private $treatmentDiseases;
	public function setTreatmentDiseases($treatmentDiseases) { $this->treatmentDiseases = $treatmentDiseases; return $this; }
	public function getTreatmentDiseases() { return $this->treatmentDiseases; }
/**************************************************************************************************************/
/* patologies *************************************************************************************************/
	private $patologies;
	public function setPatologies($patologies) { $this->patologies = $patologies; return $this; }
	public function getPatologies() { return $this->patologies; }
/**************************************************************************************************************/
/* supplementaryTest ******************************************************************************************/
	private $supplementaryTest;
	public function setSupplementaryTest($supplementaryTest) { $this->supplementaryTest = $supplementaryTest; return $this; }
	public function getSupplementaryTest() { return $this->supplementaryTest; }
/**************************************************************************************************************/
/* diagnostic *************************************************************************************************/
	private $diagnostic;
	public function setDiagnostic($diagnostic) { $this->diagnostic = $diagnostic; return $this; }
	public function getDiagnostic() { return $this->diagnostic; }
/**************************************************************************************************************/
/* treatment **************************************************************************************************/
	private $treatment;
	public function setTreatment($treatment) { $this->treatment = $treatment; return $this; }
	public function getTreatment() { return $this->treatment; }
/**************************************************************************************************************/
/* clinic *****************************************************************************************************/
	private $clinic;
    public function setClinic(\BackendBundle\Entity\Clinic $name = null) { $this->clinic = $name; return $this; }
    public function getClinic() { return $this->clinic; }
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
/* userModifier ***********************************************************************************************/
	private $userModifier;
	public function setUserModifier(\BackendBundle\Entity\User $userModifier = null) { $this->userModifier = $userModifier; return $this; }
	public function getUserModifier() { return $this->userModifier; }
/**************************************************************************************************************/
}
