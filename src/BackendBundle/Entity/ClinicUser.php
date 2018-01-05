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
class ClinicUser {
/* Id de la Tabla *********************************************************************************************/
    private $id;
    public function getId() { return $this->id; }
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
/* idClinic ***************************************************************************************************/
	private $clinic;
	public function setClinic(\BackendBundle\Entity\Clinic $clinic = null) { $this->clinic = $clinic; return $this; }
	public function getClinic() { return $this->clinic; }
/**************************************************************************************************************/
/* idUser *****************************************************************************************************/
	private $user;
	public function setUser(\BackendBundle\Entity\User $user = null) { $this->user = $user; return $this; }
	public function getUser() { return $this->user; }
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
    /*
     * la función __toString(){ return $this->gender;  } permite
     * listar los campos cuando referenciemos la tabla
     */
 //   public $cityAll = $this->getCp().", ".$this->getCp().", ".$this->getCp();
    public function __toString(){ return (string)$this->user; }
/**************************************************************************************************************/
}

