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
class TracingService {
/* Listamos Payment asociados a la TracingService *************************************************************/		
	private $invoiceServiceList;
	public function getInvoiceServiceList(){return $this->invoiceServiceList;}
	public function addInvoiceServiceList(\BackendBundle\Entity\InvoiceService $invoiceServiceList) { $this->invoiceServiceList[] = $invoiceServiceList; return $this; } 
	public function removeInvoiceServiceList(\BackendBundle\Entity\InvoiceService $invoiceServiceList) { $this->invoiceServiceList->removeElement($invoiceServiceList); }	
/**************************************************************************************************************/
/* Listamos Payment asociados a la TracingService *************************************************************/		
	private $paymentList;
	public function getPaymentList(){return $this->paymentList;}
	public function addPaymentList(\BackendBundle\Entity\Payment $payment) { $this->paymentList[] = $payment; return $this; } 
	public function removePaymentList(\BackendBundle\Entity\Payment $payment) { $this->paymentList->removeElement($payment); }	
/**************************************************************************************************************/
/* CONSTRUCTOR ************************************************************************************************/
	private $children;
	public function getChildren(){return $this->children;}
    public function addChild(\BackendBundle\Entity\TracingService $child) { $this->children[] = $child; return $this; } 
    public function removeChild(\BackendBundle\Entity\TracingService $child) { $this->children->removeElement($child); }	
/* CONSTRUCTOR ************************************************************************************************/
	//Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
	public function __construct() { 
		$this->children = new ArrayCollection(); 
		$this->paymentList = new ArrayCollection();
		$this->invoiceServiceList = new ArrayCollection(); 
	}
/**************************************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
	private $tracing;
	public function setTracing(\BackendBundle\Entity\Tracing $tracing = null) { $this->tracing = $tracing; return $this; }
	public function getTracing() { return $this->tracing; }
	private $service;
	public function setService(\BackendBundle\Entity\Service $service = null) { $this->service = $service; return $this; }
    public function getService() { return $this->service; }
	private $parent;
	public function setParent(\BackendBundle\Entity\TracingService $parent = null) { $this->parent = $parent; return $this; }
    public function getParent() { return $this->parent; }    
	private $description;
	public function setDescription($description) { $this->description = $description; return $this; }
	public function getDescription() { return $this->description; }
	private $price;
	public function setPrice($price) { $this->price = $price; return $this; }
	public function getPrice() { return $this->price; }
	private $discount;
	public function setDiscount($discount) { $this->discount = $discount; return $this; }
	public function getDiscount() { return $this->discount; }	
	private $invoiceIssued;
	public function setInvoiceIssued($invoiceIssued) { $this->invoiceIssued = $invoiceIssued; return $this; }
	public function getInvoiceIssued() { return $this->invoiceIssued; }
	private $countable;
	public function setCountable($countable) { $this->countable = $countable; return $this; }
	public function getCountable() { return $this->countable; }	
	private $consolidated;
	public function setConsolidated($consolidated) { $this->consolidated = $consolidated; return $this; }
	public function getConsolidated() { return $this->consolidated; }	
	private $modificationDate;
	public function setModificationDate($modificationDate) { $this->modificationDate = $modificationDate; return $this; }
	public function getModificationDate() { return $this->modificationDate; }
    private $userModifier;
    public function setUserModifier(\BackendBundle\Entity\User $userModifier = null) { $this->userModifier = $userModifier; return $this; }
    public function getUserModifier() { return $this->userModifier; }
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
}
