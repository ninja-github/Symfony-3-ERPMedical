<?php
/* Namespace **************************************************************************************************/
	namespace BackendBundle\Entity;

	use Symfony\Component\Validator\Constraints as Assert;
	use Doctrine\Common\Collections\ArrayCollection;
/**************************************************************************************************************/
class Payment {
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* tracing ****************************************************************************************************/
	private $tracing;
	public function setTracing(\BackendBundle\Entity\Tracing $tracing = null) { $this->tracing = $tracing; return $this; }
	public function getTracing() { return $this->tracing; }
/**************************************************************************************************************/
/* tracingService *********************************************************************************************/
	private $tracingService;
	public function setTracingService(\BackendBundle\Entity\TracingService $tracingService = null) { $this->tracingService = $tracingService; return $this; }
	public function getTracingService() { return $this->tracingService; }
/**************************************************************************************************************/
/* service ****************************************************************************************************/
	private $service;
	public function setService(\BackendBundle\Entity\Service $service = null) { $this->service = $service; return $this; }
    public function getService() { return $this->service; }
/**************************************************************************************************************/
/* invoiceIssued ****************************************************************************************************/
	private $invoiceIssued;
	public function setInvoiceIssued(\BackendBundle\Entity\InvoiceIssued $invoiceIssued = null) { $this->invoiceIssued = $invoiceIssued; return $this; }
    public function getInvoiceIssued() { return $this->invoiceIssued; }
/**************************************************************************************************************/
/* description ************************************************************************************************/   
	private $description;
	public function setDescription($description) { $this->description = $description; return $this; }
	public function getDescription() { return $this->description; }
/**************************************************************************************************************/
/* payment ****************************************************************************************************/  
	private $payment;
	public function setPayment($payment) { $this->payment = $payment; return $this; }
	public function getPayment() { return $this->payment; }
/**************************************************************************************************************/
/* countable **************************************************************************************************/  
	private $countable;
	public function setCountable($countable) { $this->countable = $countable; return $this; }
	public function getCountable() { return $this->countable; }	
/**************************************************************************************************************/
/* consolidated ***********************************************************************************************/  	
	private $consolidated;
	public function setConsolidated($consolidated) { $this->consolidated = $consolidated; return $this; }
	public function getConsolidated() { return $this->consolidated; }	
/**************************************************************************************************************/
/* user *******************************************************************************************************/
	private $user;
	public function setUser(\BackendBundle\Entity\User $user = null) { $this->user = $user; return $this; }
	public function getUser() { return $this->user; }
/**************************************************************************************************************/
/* date *******************************************************************************************************/
	private $date;
	public function setDate($date) { $this->date = $date; return $this; }
	public function getDate() { return $this->date; }
/**************************************************************************************************************/
}
