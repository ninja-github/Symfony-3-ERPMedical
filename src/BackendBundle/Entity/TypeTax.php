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
class TypeTax {
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* taxName ****************************************************************************************************/
	private $taxName;
	public function setTaxName($taxName) { $this->taxName = $taxName; return $this; }
	public function getTaxName() { return $this->taxName; }
/**************************************************************************************************************/
/* percent ****************************************************************************************************/
	private $percent;
	public function setPercent($percent) { $this->percent = $percent; return $this; }
	public function getPercent() { return $this->percent; }
/**************************************************************************************************************/
/* registrationDate *******************************************************************************************/
	private $registrationDate;
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; }
	public function getRegistrationDate() { return $this->registrationDate; }
/**************************************************************************************************************/
}

