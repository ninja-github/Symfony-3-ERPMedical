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
/**************************************************************************************************************/
/*
 * Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
 */
	use Doctrine\Common\Collections\ArrayCollection;
/*
 * También deberá incluir "use Doctrine\ORM\Mapping as ORM;"" como ORM; instrucción, que importa el
 * prefijo de anotaciones ORM.
 */
	use Doctrine\ORM\Mapping as ORM;
/**************************************************************************************************************/
class Business {
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* clinic *******************************************************************************************************/	
	private $clinic;
	public function setClinic(\BackendBundle\Entity\Clinic $clinic = null) { $this->clinic = $clinic; return $this; } 
	public function getClinic() { return $this->clinic; }
/**************************************************************************************************************/
/* businessName ***********************************************************************************************/   
	private $businessName;
	public function setBusinessName($businessName) { $this->businessName = $businessName; return $this; } 
	public function getBusinessName() { return $this->businessName; }     
/**************************************************************************************************************/
/* cif ********************************************************************************************************/ 
	private $cif;
	public function setCif($cif) { $this->cif = $cif; return $this; } 
	public function getCif() { return $this->cif; } 
/**************************************************************************************************************/
/* address ****************************************************************************************************/ 		
	private $address;
	public function setAddress($address) { $this->address = $address; return $this; } 
	public function getAddress() { return $this->address; }
/**************************************************************************************************************/
/* registrationDate *******************************************************************************************/ 		
	private $registrationDate;
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; } 
	public function getRegistrationDate() { return $this->registrationDate; }
/**************************************************************************************************************/
/* city *******************************************************************************************************/	
	private $city;
	public function setCity(\BackendBundle\Entity\AddressCity $city = null) { $this->city = $city; return $this; } 
	public function getCity() { return $this->city; }
/**************************************************************************************************************/
/* typeBusiness ***********************************************************************************************/	
	private $typeBusiness; 
	public function setTypeBusiness(\BackendBundle\Entity\TypeBusiness $typeBusiness = null) { $this->typeBusiness = $typeBusiness; return $this; }
	public function getTypeBusiness() { return $this->typeBusiness; }
/**************************************************************************************************************/	
}

