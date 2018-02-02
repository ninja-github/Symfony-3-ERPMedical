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
class Tracing {
	private $tracingServiceList;
	public function getTracingServiceList() { return $this->tracingServiceList; }
/* CONSTRUCTOR ************************************************************************************************/
	//Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
	public function __construct() {
		$this->tracingServiceList = new ArrayCollection();
    }
/**************************************************************************************************************/
/* Id de la Tabla *********************************************************************************************/
	private $id;
	public function getId() { return $this->id; }
/**************************************************************************************************************/
/* date *******************************************************************************************************/
	private $date;
	public function setDate($date) { $this->date = $date; return $this; }
	public function getDate() { return $this->date; }
/**************************************************************************************************************/
/* tracing ****************************************************************************************************/
	private $tracing;
	public function setTracing($tracing) { $this->tracing = $tracing; return $this; }
	public function getTracing() { return $this->tracing; }
/**************************************************************************************************************/
/* user *******************************************************************************************************/
	private $user;
	public function setUser(\BackendBundle\Entity\User $user = null) { $this->user = $user; return $this; }
	public function getUser() { return $this->user; }
/**************************************************************************************************************/
/* typeTracing ************************************************************************************************/
	private $typeTracing;
	public function setTypeTracing(\BackendBundle\Entity\TypeTracing $typeTracing = null) { $this->typeTracing = $typeTracing; return $this; }
	public function getTypeTracing() { return $this->typeTracing; }
/**************************************************************************************************************/
/* orthopodologyHistory ***************************************************************************************/
	private $orthopodologyHistory;
	public function setOrthopodologyHistory(\BackendBundle\Entity\OrthopodologyHistory $orthopodologyHistory = null) { $this->orthopodologyHistory = $orthopodologyHistory; return $this; }
	public function getOrthopodologyHistory() { return $this->orthopodologyHistory; }
/**************************************************************************************************************/
/* medicalHistory *********************************************************************************************/
	private $medicalHistory;
	public function setMedicalHistory(\BackendBundle\Entity\MedicalHistory $medicalHistory = null) { $this->medicalHistory = $medicalHistory; return $this; }
	public function getMedicalHistory() { return $this->medicalHistory; }
/**************************************************************************************************************/
/* googleCalendarEvent *********************************************************************************************/
	private $googleCalendarEvent;
	public function setGoogleCalendarEvent($googleCalendarEvent) { $this->googleCalendarEvent = $googleCalendarEvent; return $this; }
	public function getGoogleCalendarEvent() { return $this->googleCalendarEvent; }
/**************************************************************************************************************/

    /**
     * Add tracingServiceList
     *
     * @param \BackendBundle\Entity\TracingService $tracingServiceList
     *
     * @return Tracing
     */
    public function addTracingServiceList(\BackendBundle\Entity\TracingService $tracingServiceList)
    {
        $this->tracingServiceList[] = $tracingServiceList;

        return $this;
    }

    /**
     * Remove tracingServiceList
     *
     * @param \BackendBundle\Entity\TracingService $tracingServiceList
     */
    public function removeTracingServiceList(\BackendBundle\Entity\TracingService $tracingServiceList)
    {
        $this->tracingServiceList->removeElement($tracingServiceList);
    }
}
