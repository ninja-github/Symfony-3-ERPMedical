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
class AddressProvince{
/*
 * Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
 */
    private $addressProvince;
	public function __construct() { $this->addressProvince = new \Doctrine\Common\Collections\ArrayCollection(); }
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* province ***************************************************************************************************/
	private $province;
	public function setProvince($province) { $this->province = $province; return $this; }
	public function getProvince() { return $this->province; }
/**************************************************************************************************************/
/* idAddressCcaa **********************************************************************************************/
	private $ccaa;
	public function setCcaa(\BackendBundle\Entity\AddressCcaa $ccaa = null) { $this->ccaa = $ccaa; return $this; }
	public function getCcaa() { return $this->ccaa; }
/**************************************************************************************************************/
/* __toString *************************************************************************************************/
	/*
     * la función __toString(){ return $this->gender;  } permite
	 * listar los campos cuando referenciemos la tabla
	 */
	public function __toString(){ return (string)$this->province; }
/**************************************************************************************************************/
}