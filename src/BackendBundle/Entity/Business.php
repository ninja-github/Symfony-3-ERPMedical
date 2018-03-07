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
/* Listamos Documentos asociados a la clínica *****************************************************************/	
    private $documentsList;
    public function getDocumentsList() { return $this->documentsList; }
    public function addDocumentsList(\BackendBundle\Entity\Documents $documentsList) { $this->documentsList[] = $documentsList; return $this; } 
    public function removeDocumentsList(\BackendBundle\Entity\Documents $documentsList) { $this->documentsList->removeElement($documentsList); }  
/**************************************************************************************************************/
/**************************************************************************************************************/
	//la función __toString(){ return $this->gender;  } permite listar los campos cuando referenciemos la tabla
    public function __toString(){ return (string)$this->name.' - '.$this->brand; }
/**************************************************************************************************************/
/* CONSTRUCTOR ************************************************************************************************/
	// Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.    
	public function __construct() {	
		$this->documentsList = new ArrayCollection(); 		
	}
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* clinic *******************************************************************************************************/	
	private $clinic;
	public function setClinic(\BackendBundle\Entity\Clinic $clinic = null) { $this->clinic = $clinic; return $this; } 
	public function getClinic() { return $this->clinic; }
/**************************************************************************************************************/
/* brand ******************************************************************************************************/
	private $brand;
	public function setBrand($brand) { $this->brand = $brand; return $this; }
	public function getBrand() { return $this->brand; }
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

