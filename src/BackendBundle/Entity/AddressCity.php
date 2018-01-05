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
class AddressCity{
/*
 * Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
 */
    private $cities;
    public function __construct() { $this->cities = new ArrayCollection(); }
/* Id de la Tabla *********************************************************************************************/
    private $id;
    public function getId() { return $this->id; }
/**************************************************************************************************************/
/* cp *********************************************************************************************************/
    private $cp;
    public function setCp($cp) { $this->cp = $cp; return $this; }
    public function getCp() { return $this->cp; }
/**************************************************************************************************************/
/* city *******************************************************************************************************/
    private $city;
    public function setCity($city) { $this->city = $city; return $this; }
    public function getCity() { return $this->city; }
/**************************************************************************************************************/
/* addressProvince ******************************************************************************************/
    private $province;
    public function setProvince(\BackendBundle\Entity\AddressProvince $province = null) { $this->province = $province; return $this; }
    public function getProvince() { return $this->province; }
/**************************************************************************************************************/
    /*
     * la función __toString(){ return $this->gender;  } permite
     * listar los campos cuando referenciemos la tabla
     */
 //   public $cityAll = $this->getCp().", ".$this->getCp().", ".$this->getCp();
    public function __toString(){ return (string)$this->cp.", ".$this->city.", ".$this->province; }
/**************************************************************************************************************/
}
