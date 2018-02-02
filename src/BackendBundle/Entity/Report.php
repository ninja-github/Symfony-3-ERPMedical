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
class Report { 
/* Listamos ................................ ******************************************************************/
/**************************************************************************************************************/	
/* CONSTRUCTOR ************************************************************************************************/
	// Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.    
	public function __construct() {	
	}
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/   
/* registrationDate *******************************************************************************************/
	private $registrationDate; 
	public function setRegistrationDate($registrationdate) { $this->registrationDate = $registrationdate; return $this; } 
	public function getRegistrationDate() { return $this->registrationDate; } 
/**************************************************************************************************************/
/* reasonConsultation *****************************************************************************************/	    
	private $reasonConsultation; 
	public function setReasonConsultation($reasonConsultation) { $this->reasonConsultation = $reasonConsultation; return $this; } 
	public function getReasonConsultation() { return $this->reasonConsultation; }     
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
/* user *******************************************************************************************************/	
	private $user; 
	public function setUser(\BackendBundle\Entity\User $user = null) { $this->user = $user; return $this; } 
	public function getUser() { return $this->user; }   
/**************************************************************************************************************/
/* medicalHistory *********************************************************************************************/	  
	private $medicalHistory; 
	public function setMedicalHistory(\BackendBundle\Entity\MedicalHistory $medicalHistory = null) { $this->medicalHistory = $medicalHistory; return $this; } 
	public function getMedicalHistory() { return $this->medicalHistory; }
/**************************************************************************************************************/
}
