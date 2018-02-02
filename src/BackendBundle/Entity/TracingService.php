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
/**************************************************************************************************************/
class TracingService {
	private $tracingServices;
	public function getTracingServices() { return $this->tracingServices; }
/* CONSTRUCTOR ************************************************************************************************/
	//Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
	public function __construct() {
		$this->tracingServices = new ArrayCollection();
    }
/**************************************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
	private $description;
	public function setDescription($description) { $this->description = $description; return $this; }
	public function getDescription() { return $this->description; }
	private $price;
	public function setPrice($price) { $this->price = $price; return $this; }
	public function getPrice() { return $this->price; }
	private $registrationDate;
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; }
	public function getRegistrationDate() { return $this->registrationDate; }
	private $modificationDate;
	public function setModificationDate($modificationDate) { $this->modificationDate = $modificationDate; return $this; }
	public function getModificationDate() { return $this->modificationDate; }
	private $tracing;
	public function setTracing(\BackendBundle\Entity\Tracing $tracing = null) { $this->tracing = $tracing; return $this; }
	public function getTracing() { return $this->tracing; }
	private $invoice;
	public function setInvoice(\BackendBundle\Entity\Invoice $invoice = null) { $this->invoice = $invoice; return $this; }
	public function getInvoice() { return $this->invoice; }
	private $service;
	public function setService(\BackendBundle\Entity\Service $service = null) { $this->service = $service; return $this; }
    public function getService() { return $this->service; }
	private $userRegisterer;
    public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null) { $this->userRegisterer = $userRegisterer; return $this; }
    public function getUserRegisterer() { return $this->userRegisterer; }
    private $userModifier;
    public function setUserModifier(\BackendBundle\Entity\User $userModifier = null) { $this->userModifier = $userModifier; return $this; }
    public function getUserModifier() { return $this->userModifier; }
}
