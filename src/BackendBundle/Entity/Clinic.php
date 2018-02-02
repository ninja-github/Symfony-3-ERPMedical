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
	use Doctrine\Common\Collections\Collection;	
/**************************************************************************************************************/
class Clinic {
/* Listamos Historias Médicas asociadas a la clínica ******************************************************************/	
	private $medicalHistoryList;
	public function getMedicalHistoryList() { return $this->medicalHistoryList; }
	public function addMedicalHistoryList(\BackendBundle\Entity\MedicalHistory $medicalHistoryList) { $this->medicalHistoryList[] = $medicalHistoryList; return $this; } 
	public function removeMedicalHistoryList(\BackendBundle\Entity\MedicalHistory $medicalHistoryList) { $this->medicalHistoryList->removeElement($medicalHistoryList); }
/**************************************************************************************************************/
/* Listamos Empresas asociadas a la clínica ******************************************************************/	
	private $businessList;
	public function getBusinessList() { return $this->businessList; }
	public function addBusinessList(\BackendBundle\Entity\Business $businessList) { $this->businessList[] = $businessList; return $this; } 
	public function removeBusinessList(\BackendBundle\Entity\Business $businessList) { $this->businessList->removeElement($businessList); }
/**************************************************************************************************************/
/* Listamos Servicios asociados a la clínica ******************************************************************/	
	private $servicesList;
	public function getServicesList() { return $this->servicesList; }
	public function addServicesList(\BackendBundle\Entity\Service $servicesList) { $this->servicesList[] = $servicesList; return $this; } 
	public function removeServicesList(\BackendBundle\Entity\Service $servicesList) { $this->servicesList->removeElement($servicesList); }
/**************************************************************************************************************/
/* CONSTRUCTOR ************************************************************************************************/
	// Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.    
	public function __construct() {	
		$this->medicalHistoryList = new ArrayCollection(); 
		$this->businessList = new ArrayCollection(); 		
		$this->servicesList = new ArrayCollection(); 
	}
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* name *******************************************************************************************************/
	private $name;
	public function setName($name) { $this->name = $name; return $this; }
	public function getName() { return $this->name; }
/**************************************************************************************************************/
/* nameUrl ****************************************************************************************************/
	private $nameUrl;
	public function setNameUrl($nameUrl) { $this->nameUrl = $nameUrl; return $this; }
	public function getNameUrl() { return $this->nameUrl; }
/**************************************************************************************************************/
/* image ******************************************************************************************************/
	private $image;
	public function setImage($image) {  $this->image = $image; return $this; }
	public function getImage() { return $this->image; }
/**************************************************************************************************************/
/* email ******************************************************************************************************/
	private $email;
	public function setEmail($email) { $this->email = $email; return $this; }
	public function getEmail() { return $this->email; }
/**************************************************************************************************************/
/* phone ******************************************************************************************************/
	private $phone;
	public function setPhone($phone) { $this->phone = $phone; return $this; }
	public function getPhone() { return $this->phone; }
/**************************************************************************************************************/
/* address ****************************************************************************************************/
	private $address;
	public function setAddress($address) { $this->address = $address; return $this; }
	public function getAddress() { return $this->address; }
/**************************************************************************************************************/
/* address ****************************************************************************************************/
	private $noteReport;
	public function setNoteReport($noteReport) { $this->noteReport = $noteReport; return $this; }
	public function getNoteReport() { return $this->noteReport; }
/**************************************************************************************************************/
/* address ****************************************************************************************************/
	private $noteInvoice;
	public function setNoteInvoice($noteInvoice) { $this->noteInvoice = $noteInvoice; return $this; }
	public function getNoteInvoice() { return $this->noteInvoice; }
/**************************************************************************************************************/
/* registrationDate *******************************************************************************************/
	private $registrationDate;
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; }
	public function getRegistrationDate() { return $this->registrationDate; }
/**************************************************************************************************************/
/* modificationDate *******************************************************************************************/
	private $modificationDate;
	public function setModificationDate($modificationDate) { $this->modificationDate = $modificationDate; return $this; }
	public function getModificationDate() { return $this->modificationDate; }
/**************************************************************************************************************/
/* city *******************************************************************************************************/
	private $city;
	public function setCity (\BackendBundle\Entity\AddressCity $city = null) { $this->city = $city; return $this; }
	public function getCity() { return $this->city; }    
/**************************************************************************************************************/
/* idUserRegisterer *******************************************************************************************/
	private $userRegisterer;
	public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null) { $this->userRegisterer = $userRegisterer; return $this; }
	public function getUserRegisterer() { return $this->userRegisterer; }
/**************************************************************************************************************/
/* idUserModifier *********************************************************************************************/
	private $userModifier;
	public function setUserModifier(\BackendBundle\Entity\User $userModifier = null) { $this->userModifier = $userModifier; return $this; }
	public function getUserModifier() { return $this->userModifier; }
/**************************************************************************************************************/
}
