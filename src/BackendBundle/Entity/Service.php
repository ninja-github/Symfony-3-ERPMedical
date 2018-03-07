<?php
// LIBRERIA JS PARA GESTION DEL ORDEN DE SERVICIOS
// https://johnny.github.io/jquery-sortable/
/* Namespace **************************************************************************************************/
	namespace BackendBundle\Entity;
/* Añadimos el VALIDADOR **************************************************************************************/
	use Doctrine\Common\Collections\ArrayCollection;
/**************************************************************************************************************/
class Service {
	private $children;
	public function getChildren(){return $this->children;}
    public function addChild(\BackendBundle\Entity\Service $child) { $this->children[] = $child; return $this; } 
    public function removeChild(\BackendBundle\Entity\Service $child) { $this->children->removeElement($child); }	
	public function __construct() { $this->children = new ArrayCollection(); }
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* $name ***************************************************************************************************/
	private $name; 
	public function setName($name) { $this->name = $name; return $this; }
	public function getName() { return $this->name; }     
/**************************************************************************************************************/
/* $typeService ***********************************************************************************************/
	private $typeService = '0'; 
	public function setTypeService($typeService) { $this->typeService = $typeService; return $this; }
	public function getTypeService() { return $this->typeService; }     
/**************************************************************************************************************/
/* $parent ****************************************************************************************************/
	private $parent;
	public function setParent(\BackendBundle\Entity\Service $parent = null) { $this->parent = $parent; return $this; } 
	public function getParent() { return $this->parent; } 	
/**************************************************************************************************************/
/* $weight ****************************************************************************************************/
	private $weight = '1'; 
	public function setWeight($weight) { $this->weight = $weight; return $this; }
	public function getWeight() { return $this->weight; }     
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
	private $clinic; 
	public function setClinic(\BackendBundle\Entity\Clinic $clinic = null) { $this->clinic = $clinic; return $this; }
	public function getClinic() { return $this->clinic; }	
/**************************************************************************************************************/
	private $updatedService; 
	public function setUpdatedService(\BackendBundle\Entity\Service $updatedService = null) { $this->updatedService = $updatedService; return $this; } 
	public function getUpdatedService() { return $this->updatedService; } 	
/**************************************************************************************************************/
	private $typeTaxService; 
	public function setTypeTaxService(\BackendBundle\Entity\typeTaxService $typeTaxService = null) { $this->typeTaxService = $typeTaxService; return $this; } 
	public function getTypeTaxService() { return $this->typeTaxService; } 	
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
