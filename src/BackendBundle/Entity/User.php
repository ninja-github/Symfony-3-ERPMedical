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
/*
 * Para cargar usuarios de seguridad de la base de datos (el proveedor de la entidad)
 * además implementaremos la clase a partir de UserInterface, Serializable
 */
	use Symfony\Component\Security\Core\User\UserInterface;
/**************************************************************************************************************/
class User implements UserInterface, \Serializable {
	private $clinicList;
	public function getClinicList() { return $this->clinicList; }
	public function __construct() {
		$this->clinicList = new ArrayCollection(); 		
	}
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* userName ***************************************************************************************************/
	private $userName;
	public function setUserName($userName) { $this->userName = $userName; return $this; }
	public function getUserName() { return $this->userName; }
/* name *******************************************************************************************************/
	private $name;
	public function setName($name) { $this->name = $name; return $this; }
	public function getName() { return $this->name; }
/**************************************************************************************************************/
/* surname ****************************************************************************************************/
	private $surnames;
	public function setSurnames($surnames) { $this->surnames = $surnames; return $this; }
	public function getSurnames() { return $this->surnames; }
/**************************************************************************************************************/
/* password ***************************************************************************************************/
	private $password;
	public function setPassword($password) { $this->password = $password; return $this; }
	public function getPassword() { return $this->password; }
/**************************************************************************************************************/
/* email ******************************************************************************************************/
	private $email;
	public function setEmail($email) { $this->email = $email; return $this; }
	public function getEmail() { return $this->email; }
/**************************************************************************************************************/
/* role *******************************************************************************************************/
	private $role;
	public function setRole($role) { $this->role = $role; return $this; }
	public function getRole() { return $this->role; }
	public function getRoles(){ return array('ROLE_USER','ROLE ADMIN'); }
/**************************************************************************************************************/
/* image ******************************************************************************************************/
	private $image;
	public function setImage($image) {  $this->image = $image; return $this; }
	public function getImage() { return $this->image; }
/**************************************************************************************************************/
/* idTypeGender ***********************************************************************************************/
	private $gender;
	public function setGender(\BackendBundle\Entity\TypeGender $type = null) { $this->gender = $type; return $this; }
	public function getGender() { return $this->gender; }
/**************************************************************************************************************/
/* idUserRegisterer *******************************************************************************************/
	private $userRegisterer;
	public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null) { $this->userRegisterer = $userRegisterer; return $this; }
	public function getUserRegisterer() { return $this->userRegisterer; }
/**************************************************************************************************************/
/* registrationDate *******************************************************************************************/
	private $registrationDate;
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; }
	public function getRegistrationDate() { return $this->registrationDate; }
/**************************************************************************************************************/
/* idUserModifier *********************************************************************************************/
	private $userModifier;
	public function setUserModifier(\BackendBundle\Entity\User $userModifier = null) { $this->userModifier = $userModifier; return $this; }
	public function getUserModifier() { return $this->userModifier; }
/**************************************************************************************************************/
/* modificationDate *******************************************************************************************/
	private $modificationDate;
	public function setModificationDate($modificationDate) { $this->modificationDate = $modificationDate; return $this; }
	public function getModificationDate() { return $this->modificationDate; }
/**************************************************************************************************************/
/* INTRODUCIMOS LOS SIGUIENTES MÉTODOS ************************************************************************/
	public function getSalt(){ return null; }
	public function eraseCredentials(){  }
/**************************************************************************************************************/
/* INTRODUCIMOS MÉTODOS SERIALIZABLES - Facilita la subida y actualización de imágenes en los formularios */
	public function serialize(){ return serialize (array( $this->id, $this->userName, $this->password )); }
	public function unserialize ($serialized){ list( $this->id, $this->userName, $this->password ) = unserialize ($serialized); }
/**************************************************************************************************************/
	private $user;
	public function getUser() { return $this->name." ".$this->surnames; }
	/*
	 * la función __toString(){ return $this->userName;;  } permite
	 * listar los campos cuando referenciemos la tabla
	 */
	public function __toString(){ return $this->user;  }
/**************************************************************************************************************/
}

