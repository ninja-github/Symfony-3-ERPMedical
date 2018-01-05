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
class Service {
	private $children;
	public function getChildren(){return $this->children;}
	public function __construct() { $this->children = new ArrayCollection(); }
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* $service ***************************************************************************************************/
	private $service; 
	public function setService($service) { $this->service = $service; return $this; }
	public function getService() { return $this->service; }     
/**************************************************************************************************************/
	private $description; 
	public function setDescription($description) { $this->description = $description; return $this; } 
	public function getDescription() { return $this->description; }     
/**************************************************************************************************************/
	private $minimalPrice;
	public function setMinimalPrice($minimalPrice) { $this->minimalPrice = $minimalPrice; return $this; } 
	public function getMinimalPrice() { return $this->minimalPrice; } 	
/**************************************************************************************************************/
	private $maximumPrice;
	public function setMaximumPrice($maximumPrice) { $this->maximumPrice = $maximumPrice; return $this; } 
	public function getMaximumPrice() { return $this->maximumPrice; } 
/**************************************************************************************************************/
	private $registrationDate;
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; } 
	public function getRegistrationDate() { return $this->registrationDate; } 
/**************************************************************************************************************/
	private $modificationDate;
	public function setModificationDate($modificationDate) { $this->modificationDate = $modificationDate; return $this; }
	public function getModificationDate() { return $this->modificationDate; }
/**************************************************************************************************************/
	private $state = '1'; 
	public function setState($state) { $this->state = $state; return $this; } 
	public function getState() { return $this->state; } 
/**************************************************************************************************************/
	private $parent;
	public function setParent(\BackendBundle\Entity\Service $parent = null) { $this->parent = $parent; return $this; } 
	public function getParent() { return $this->parent; } 
/**************************************************************************************************************/
	private $clinic; 
	public function setClinic(\BackendBundle\Entity\Clinic $clinic = null) { $this->clinic = $clinic; return $this; }
	public function getClinic() { return $this->clinic; }	
/**************************************************************************************************************/
	private $updatedService; 
	public function setUpdatedService(\BackendBundle\Entity\Service $updatedService = null) { $this->updatedService = $updatedService; return $this; } 
	public function getUpdatedService() { return $this->updatedService; } 	
/**************************************************************************************************************/
	private $typeTax; 
	public function setTypeTax(\BackendBundle\Entity\TypeTax $typeTax = null) { $this->typeTax = $typeTax; return $this; } 
	public function getTypeTax() { return $this->typeTax; } 	
/**************************************************************************************************************/
	private $userModifier; 
	public function setUserModifier(\BackendBundle\Entity\User $UserModifier = null) { $this->userModifier = $userModifier; return $this; } 
	public function getUserModifier() { return $this->userModifier; }	
/**************************************************************************************************************/
	private $userRegisterer;
	public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null) { $this->userRegisterer = $userRegisterer; return $this; } 
	public function getUserRegisterer() { return $this->userRegisterer; }
/**************************************************************************************************************/
}

