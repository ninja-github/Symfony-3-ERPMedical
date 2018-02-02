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
class UserSession{
/* Id de la Tabla *********************************************************************************************/
    private $id;
    public function getId() { return $this->id; }
/**************************************************************************************************************/
/* datetime ***************************************************************************************************/
    private $datetime;
    public function setDatetime($datetime) { $this->datetime = $datetime; return $this; }
    public function getDatetime() { return $this->datetime; }
/**************************************************************************************************************/
/* pathInfo ***************************************************************************************************/
    private $pathInfo;
    public function setPathInfo($pathInfo) { $this->pathInfo = $pathInfo; return $this; }
    public function getPathInfo() { return $this->pathInfo; }
/**************************************************************************************************************/
/* ip *********************************************************************************************************/
    private $ip;
    public function setIp($ip) { $this->ip = $ip; return $this; }
    public function getIp() { return $this->ip; }
/**************************************************************************************************************/
/* idUser *****************************************************************************************************/
    private $user;
    public function setUser(\BackendBundle\Entity\User $user = null) { $this->user = $user; return $this; }
    public function getUser() { return $this->user; }
/**************************************************************************************************************/
}
