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
class TypeTracing {
/*
 * Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
 */
    private $typeTracingArray;
    public function __construct() { $this->typeTracingArray = new ArrayCollection(); }
/* Id de la Tabla *********************************************************************************************/    private $id;
    public function getId() { return $this->id; }
/**************************************************************************************************************/
/* typeTracing ************************************************************************************************/
    private $type;
    public function setType($type) { $this->type = $type; return $this; }
    public function getType() { return $this->type; }
/**************************************************************************************************************/
/* translate **************************************************************************************************/
    private $translate;
    public function setTranslate($translate) { $this->translate = $translate; return $this; }
    public function getTranslate() { return $this->translate; }
/**************************************************************************************************************/
    /*
     * la función __toString(){ return $this->gender;  } permite
     * listar los campos cuando referenciemos la tabla
     */
    public function __toString(){ return (string)$this->type; }
/**************************************************************************************************************/
}
