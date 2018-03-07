<?php
/* Namespace **************************************************************************************************/
    namespace BackendBundle\Entity;

    use Symfony\Component\Validator\Constraints as Assert;
    use Doctrine\Common\Collections\ArrayCollection;
    use Doctrine\Common\Collections\Collection;
/**************************************************************************************************************/
class InvoiceReceived {
/* Id de la Tabla *********************************************************************************************/
    private $id;
    public function getId() { return $this->id; }
/**************************************************************************************************************/
/* documents **************************************************************************************************/
	private $uploadDocuments;
	public function setUploadDocuments($uploadDocuments) { $this->uploadDocuments = $uploadDocuments; return $this; }
	public function getUploadDocuments() { return $this->uploadDocuments; }
/**************************************************************************************************************/
/* clinic *****************************************************************************************************/
	private $clinic;
    public function setClinic(\BackendBundle\Entity\Clinic $name = null) { $this->clinic = $name; return $this; }
    public function getClinic() { return $this->clinic; }
/**************************************************************************************************************/
/* documents **************************************************************************************************/
	private $documents;
	public function setDocuments(\BackendBundle\Entity\Documents $documents = null) { $this->documents = $documents; return $this; }
	public function getDocuments() { return $this->documents; }
/**************************************************************************************************************/
/* business ***************************************************************************************************/
	private $business;
    public function setBusiness(\BackendBundle\Entity\Business $business = null) { $this->business = $business; return $this; }
    public function getBusiness() { return $this->business; }
/**************************************************************************************************************/
/* invoiceNumber **********************************************************************************************/
	private $invoiceNumber;
	public function setInvoiceNumber($invoiceNumber) { $this->invoiceNumber = $invoiceNumber; return $this; }
	public function getInvoiceNumber() { return $this->invoiceNumber; }
/**************************************************************************************************************/
/* taxBase ****************************************************************************************************/
	private $taxBase;
	public function setTaxBase($taxBase) { $this->taxBase = $taxBase; return $this; }
	public function getTaxBase() { return $this->taxBase; }
/**************************************************************************************************************/
/* note *******************************************************************************************************/
	private $note;
	public function setNote($note) { $this->note = $note; return $this; }
	public function getNote() { return $this->note; }
/**************************************************************************************************************/
/* iva ********************************************************************************************************/
	private $iva;
	public function setIva($iva) { $this->iva = $iva; return $this; }
	public function getIva() { return $this->iva; }
/**************************************************************************************************************/
/* irpf *******************************************************************************************************/
	private $irpf;
	public function setIrpf($irpf) { $this->irpf = $irpf; return $this; }
	public function getIrpf() { return $this->irpf; }
/**************************************************************************************************************/
/* re *********************************************************************************************************/
	private $re;
	public function setRe($re) { $this->re = $re; return $this; }
	public function getRe() { return $this->re; }
/**************************************************************************************************************/
/* paidOut ****************************************************************************************************/
	private $paidOut;
	public function setPaidOut($paidOut = 0) { $this->paidOut = $paidOut; return $this; }
	public function getPaidOut() { return $this->paidOut; }
/**************************************************************************************************************/
/* registrationDate *******************************************************************************************/
	private $registrationDate;
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; }
	public function getRegistrationDate() { return $this->registrationDate; }
/**************************************************************************************************************/
/* userRegisterer *********************************************************************************************/
	private $userRegisterer;
	public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null) { $this->userRegisterer = $userRegisterer; return $this; }
	public function getUserRegisterer() { return $this->userRegisterer; }
/**************************************************************************************************************/
}

