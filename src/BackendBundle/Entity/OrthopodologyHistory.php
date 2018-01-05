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
class OrthopodologyHistory {
/* Listamos Historias Médicas *********************************************************************************/
	private $docList;
	public function getDocList() { return $this->docList; }
	private $tracingList;
	public function getTracingList() { return $this->tracingList; }
/* CONSTRUCTOR ************************************************************************************************/
	//Un ArrayCollection es una implementación de colección que se ajusta a la matriz PHP normal.
	public function __construct() {
		$this->docList = new ArrayCollection();
		$this->tracingList = new ArrayCollection();
	}
/**************************************************************************************************************/
/* Id de la Tabla *********************************************************************************************/
    private $id;
    public function getId() { return $this->id; }
/**************************************************************************************************************/
/* service ****************************************************************************************************/
    private $reasonConsultation;
    private $background;
    private $articularExplorationRotaryPatternExternalLeft;
    private $articularExplorationRotaryPatternExternalRight;

    /**
     * @var integer
     */
    private $articularExplorationRotaryPatternInternalLeft;

    /**
     * @var integer
     */
    private $articularExplorationRotaryPatternInternalRight;

    /**
     * @var integer
     */
    private $articularExplorationHipLeft;

    /**
     * @var integer
     */
    private $articularExplorationHipRight;

    /**
     * @var string
     */
    private $articularExplorationKneeLeft;

    /**
     * @var string
     */
    private $articularExplorationKneeRight;

    /**
     * @var string
     */
    private $articularExplorationAnkleLeft;

    /**
     * @var string
     */
    private $articularExplorationAnkleRight;

    /**
     * @var string
     */
    private $articularExplorationRetroPieLeft;

    /**
     * @var string
     */
    private $articularExplorationRetroPieRight;

    /**
     * @var string
     */
    private $articularExplorationBeforeFootLeft;

    /**
     * @var string
     */
    private $articularExplorationBeforeFootRight;

    /**
     * @var string
     */
    private $articularExplorationFirstRadioLeft;

    /**
     * @var string
     */
    private $articularExplorationFirstRadioRight;

    /**
     * @var string
     */
    private $articularExplorationFifthRadioLeft;

    /**
     * @var string
     */
    private $articularExplorationFifthRadioRight;

    /**
     * @var string
     */
    private $articularExplorationCentralRadiosLeft;

    /**
     * @var string
     */
    private $articularExplorationCentralRadiosRight;

    /**
     * @var string
     */
    private $articularExplorationFirstFingerLeft;

    /**
     * @var string
     */
    private $articularExplorationFirstFingerRight;

    /**
     * @var string
     */
    private $articularExplorationSmallerFingersLeft;

    /**
     * @var string
     */
    private $articularExplorationSmallerFingersRight;

    /**
     * @var string
     */
    private $torsionsFemoralLeft;

    /**
     * @var string
     */
    private $torsionsFemoralRight;

    /**
     * @var string
     */
    private $torsionsGenusLeft;

    /**
     * @var string
     */
    private $torsionsGenusRight;

    /**
     * @var string
     */
    private $torsionsAngleQLeft;

    /**
     * @var string
     */
    private $torsionsAngleQRight;

    /**
     * @var string
     */
    private $torsionsTibialLeft;

    /**
     * @var string
     */
    private $torsionsTibialRight;

    /**
     * @var string
     */
    private $torsionsHelbingLeft;

    /**
     * @var string
     */
    private $torsionsHelbingRight;

    /**
     * @var string
     */
    private $dissimmetry;

    /**
     * @var string
     */
    private $muscularExplorationDorsalFlexionLeft;

    /**
     * @var string
     */
    private $muscularExplorationDorsalFlexionRight;

    /**
     * @var string
     */
    private $muscularExplorationPlantarFlexionLeft;

    /**
     * @var string
     */
    private $muscularExplorationPlantarFlexionRight;

    /**
     * @var string
     */
    private $muscularExplorationEversionLeft;

    /**
     * @var string
     */
    private $muscularExplorationEversionRight;

    /**
     * @var string
     */
    private $muscularExplorationReversalLeft;

    /**
     * @var string
     */
    private $muscularExplorationReversalRight;

    /**
     * @var string
     */
    private $dinamicExploration;

    /**
     * @var string
     */
    private $signsFootprint;

    /**
     * @var string
     */
    private $suplementaryTest;

    /**
     * @var string
     */
    private $diagnostic;

    /**
     * @var string
     */
    private $treatment;

    /**
     * @var \DateTime
     */
    private $registrationDate;

    /**
     * @var \DateTime
     */
    private $modificationDate;

    /**
     * @var \BackendBundle\Entity\MedicalHistory
     */

    public function setReasonConsultation($reasonConsultation)
    {
        $this->reasonConsultation = $reasonConsultation;

        return $this;
    }

    /**
     * Get reasonConsultation
     *
     * @return string
     */
    public function getReasonConsultation()
    {
        return $this->reasonConsultation;
    }

    /**
     * Set background
     *
     * @param string $background
     *
     * @return OrthopodologyHistory
     */
    public function setBackground($background)
    {
        $this->background = $background;

        return $this;
    }

    /**
     * Get background
     *
     * @return string
     */
    public function getBackground()
    {
        return $this->background;
    }

    /**
     * Set articularExplorationRotaryPatternExternalLeft
     *
     * @param integer $articularExplorationRotaryPatternExternalLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationRotaryPatternExternalLeft($articularExplorationRotaryPatternExternalLeft)
    {
        $this->articularExplorationRotaryPatternExternalLeft = $articularExplorationRotaryPatternExternalLeft;

        return $this;
    }

    /**
     * Get articularExplorationRotaryPatternExternalLeft
     *
     * @return integer
     */
    public function getArticularExplorationRotaryPatternExternalLeft()
    {
        return $this->articularExplorationRotaryPatternExternalLeft;
    }

    /**
     * Set articularExplorationRotaryPatternExternalRight
     *
     * @param integer $articularExplorationRotaryPatternExternalRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationRotaryPatternExternalRight($articularExplorationRotaryPatternExternalRight)
    {
        $this->articularExplorationRotaryPatternExternalRight = $articularExplorationRotaryPatternExternalRight;

        return $this;
    }

    /**
     * Get articularExplorationRotaryPatternExternalRight
     *
     * @return integer
     */
    public function getArticularExplorationRotaryPatternExternalRight()
    {
        return $this->articularExplorationRotaryPatternExternalRight;
    }

    /**
     * Set articularExplorationRotaryPatternInternalLeft
     *
     * @param integer $articularExplorationRotaryPatternInternalLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationRotaryPatternInternalLeft($articularExplorationRotaryPatternInternalLeft)
    {
        $this->articularExplorationRotaryPatternInternalLeft = $articularExplorationRotaryPatternInternalLeft;

        return $this;
    }

    /**
     * Get articularExplorationRotaryPatternInternalLeft
     *
     * @return integer
     */
    public function getArticularExplorationRotaryPatternInternalLeft()
    {
        return $this->articularExplorationRotaryPatternInternalLeft;
    }

    /**
     * Set articularExplorationRotaryPatternInternalRight
     *
     * @param integer $articularExplorationRotaryPatternInternalRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationRotaryPatternInternalRight($articularExplorationRotaryPatternInternalRight)
    {
        $this->articularExplorationRotaryPatternInternalRight = $articularExplorationRotaryPatternInternalRight;

        return $this;
    }

    /**
     * Get articularExplorationRotaryPatternInternalRight
     *
     * @return integer
     */
    public function getArticularExplorationRotaryPatternInternalRight()
    {
        return $this->articularExplorationRotaryPatternInternalRight;
    }

    /**
     * Set articularExplorationHipLeft
     *
     * @param integer $articularExplorationHipLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationHipLeft($articularExplorationHipLeft)
    {
        $this->articularExplorationHipLeft = $articularExplorationHipLeft;

        return $this;
    }

    /**
     * Get articularExplorationHipLeft
     *
     * @return integer
     */
    public function getArticularExplorationHipLeft()
    {
        return $this->articularExplorationHipLeft;
    }

    /**
     * Set articularExplorationHipRight
     *
     * @param integer $articularExplorationHipRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationHipRight($articularExplorationHipRight)
    {
        $this->articularExplorationHipRight = $articularExplorationHipRight;

        return $this;
    }

    /**
     * Get articularExplorationHipRight
     *
     * @return integer
     */
    public function getArticularExplorationHipRight()
    {
        return $this->articularExplorationHipRight;
    }

    /**
     * Set articularExplorationKneeLeft
     *
     * @param string $articularExplorationKneeLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationKneeLeft($articularExplorationKneeLeft)
    {
        $this->articularExplorationKneeLeft = $articularExplorationKneeLeft;

        return $this;
    }

    /**
     * Get articularExplorationKneeLeft
     *
     * @return string
     */
    public function getArticularExplorationKneeLeft()
    {
        return $this->articularExplorationKneeLeft;
    }

    /**
     * Set articularExplorationKneeRight
     *
     * @param string $articularExplorationKneeRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationKneeRight($articularExplorationKneeRight)
    {
        $this->articularExplorationKneeRight = $articularExplorationKneeRight;

        return $this;
    }

    /**
     * Get articularExplorationKneeRight
     *
     * @return string
     */
    public function getArticularExplorationKneeRight()
    {
        return $this->articularExplorationKneeRight;
    }

    /**
     * Set articularExplorationAnkleLeft
     *
     * @param string $articularExplorationAnkleLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationAnkleLeft($articularExplorationAnkleLeft)
    {
        $this->articularExplorationAnkleLeft = $articularExplorationAnkleLeft;

        return $this;
    }

    /**
     * Get articularExplorationAnkleLeft
     *
     * @return string
     */
    public function getArticularExplorationAnkleLeft()
    {
        return $this->articularExplorationAnkleLeft;
    }

    /**
     * Set articularExplorationAnkleRight
     *
     * @param string $articularExplorationAnkleRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationAnkleRight($articularExplorationAnkleRight)
    {
        $this->articularExplorationAnkleRight = $articularExplorationAnkleRight;

        return $this;
    }

    /**
     * Get articularExplorationAnkleRight
     *
     * @return string
     */
    public function getArticularExplorationAnkleRight()
    {
        return $this->articularExplorationAnkleRight;
    }

    /**
     * Set articularExplorationRetroPieLeft
     *
     * @param string $articularExplorationRetroPieLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationRetroPieLeft($articularExplorationRetroPieLeft)
    {
        $this->articularExplorationRetroPieLeft = $articularExplorationRetroPieLeft;

        return $this;
    }

    /**
     * Get articularExplorationRetroPieLeft
     *
     * @return string
     */
    public function getArticularExplorationRetroPieLeft()
    {
        return $this->articularExplorationRetroPieLeft;
    }

    /**
     * Set articularExplorationRetroPieRight
     *
     * @param string $articularExplorationRetroPieRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationRetroPieRight($articularExplorationRetroPieRight)
    {
        $this->articularExplorationRetroPieRight = $articularExplorationRetroPieRight;

        return $this;
    }

    /**
     * Get articularExplorationRetroPieRight
     *
     * @return string
     */
    public function getArticularExplorationRetroPieRight()
    {
        return $this->articularExplorationRetroPieRight;
    }

    /**
     * Set articularExplorationBeforeFootLeft
     *
     * @param string $articularExplorationBeforeFootLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationBeforeFootLeft($articularExplorationBeforeFootLeft)
    {
        $this->articularExplorationBeforeFootLeft = $articularExplorationBeforeFootLeft;

        return $this;
    }

    /**
     * Get articularExplorationBeforeFootLeft
     *
     * @return string
     */
    public function getArticularExplorationBeforeFootLeft()
    {
        return $this->articularExplorationBeforeFootLeft;
    }

    /**
     * Set articularExplorationBeforeFootRight
     *
     * @param string $articularExplorationBeforeFootRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationBeforeFootRight($articularExplorationBeforeFootRight)
    {
        $this->articularExplorationBeforeFootRight = $articularExplorationBeforeFootRight;

        return $this;
    }

    /**
     * Get articularExplorationBeforeFootRight
     *
     * @return string
     */
    public function getArticularExplorationBeforeFootRight()
    {
        return $this->articularExplorationBeforeFootRight;
    }

    /**
     * Set articularExplorationFirstRadioLeft
     *
     * @param string $articularExplorationFirstRadioLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationFirstRadioLeft($articularExplorationFirstRadioLeft)
    {
        $this->articularExplorationFirstRadioLeft = $articularExplorationFirstRadioLeft;

        return $this;
    }

    /**
     * Get articularExplorationFirstRadioLeft
     *
     * @return string
     */
    public function getArticularExplorationFirstRadioLeft()
    {
        return $this->articularExplorationFirstRadioLeft;
    }

    /**
     * Set articularExplorationFirstRadioRight
     *
     * @param string $articularExplorationFirstRadioRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationFirstRadioRight($articularExplorationFirstRadioRight)
    {
        $this->articularExplorationFirstRadioRight = $articularExplorationFirstRadioRight;

        return $this;
    }

    /**
     * Get articularExplorationFirstRadioRight
     *
     * @return string
     */
    public function getArticularExplorationFirstRadioRight()
    {
        return $this->articularExplorationFirstRadioRight;
    }

    /**
     * Set articularExplorationFifthRadioLeft
     *
     * @param string $articularExplorationFifthRadioLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationFifthRadioLeft($articularExplorationFifthRadioLeft)
    {
        $this->articularExplorationFifthRadioLeft = $articularExplorationFifthRadioLeft;

        return $this;
    }

    /**
     * Get articularExplorationFifthRadioLeft
     *
     * @return string
     */
    public function getArticularExplorationFifthRadioLeft()
    {
        return $this->articularExplorationFifthRadioLeft;
    }

    /**
     * Set articularExplorationFifthRadioRight
     *
     * @param string $articularExplorationFifthRadioRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationFifthRadioRight($articularExplorationFifthRadioRight)
    {
        $this->articularExplorationFifthRadioRight = $articularExplorationFifthRadioRight;

        return $this;
    }

    /**
     * Get articularExplorationFifthRadioRight
     *
     * @return string
     */
    public function getArticularExplorationFifthRadioRight()
    {
        return $this->articularExplorationFifthRadioRight;
    }

    /**
     * Set articularExplorationCentralRadiosLeft
     *
     * @param string $articularExplorationCentralRadiosLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationCentralRadiosLeft($articularExplorationCentralRadiosLeft)
    {
        $this->articularExplorationCentralRadiosLeft = $articularExplorationCentralRadiosLeft;

        return $this;
    }

    /**
     * Get articularExplorationCentralRadiosLeft
     *
     * @return string
     */
    public function getArticularExplorationCentralRadiosLeft()
    {
        return $this->articularExplorationCentralRadiosLeft;
    }

    /**
     * Set articularExplorationCentralRadiosRight
     *
     * @param string $articularExplorationCentralRadiosRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationCentralRadiosRight($articularExplorationCentralRadiosRight)
    {
        $this->articularExplorationCentralRadiosRight = $articularExplorationCentralRadiosRight;

        return $this;
    }

    /**
     * Get articularExplorationCentralRadiosRight
     *
     * @return string
     */
    public function getArticularExplorationCentralRadiosRight()
    {
        return $this->articularExplorationCentralRadiosRight;
    }

    /**
     * Set articularExplorationFirstFingerLeft
     *
     * @param string $articularExplorationFirstFingerLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationFirstFingerLeft($articularExplorationFirstFingerLeft)
    {
        $this->articularExplorationFirstFingerLeft = $articularExplorationFirstFingerLeft;

        return $this;
    }

    /**
     * Get articularExplorationFirstFingerLeft
     *
     * @return string
     */
    public function getArticularExplorationFirstFingerLeft()
    {
        return $this->articularExplorationFirstFingerLeft;
    }

    /**
     * Set articularExplorationFirstFingerRight
     *
     * @param string $articularExplorationFirstFingerRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationFirstFingerRight($articularExplorationFirstFingerRight)
    {
        $this->articularExplorationFirstFingerRight = $articularExplorationFirstFingerRight;

        return $this;
    }

    /**
     * Get articularExplorationFirstFingerRight
     *
     * @return string
     */
    public function getArticularExplorationFirstFingerRight()
    {
        return $this->articularExplorationFirstFingerRight;
    }

    /**
     * Set articularExplorationSmallerFingersLeft
     *
     * @param string $articularExplorationSmallerFingersLeft
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationSmallerFingersLeft($articularExplorationSmallerFingersLeft)
    {
        $this->articularExplorationSmallerFingersLeft = $articularExplorationSmallerFingersLeft;

        return $this;
    }

    /**
     * Get articularExplorationSmallerFingersLeft
     *
     * @return string
     */
    public function getArticularExplorationSmallerFingersLeft()
    {
        return $this->articularExplorationSmallerFingersLeft;
    }

    /**
     * Set articularExplorationSmallerFingersRight
     *
     * @param string $articularExplorationSmallerFingersRight
     *
     * @return OrthopodologyHistory
     */
    public function setArticularExplorationSmallerFingersRight($articularExplorationSmallerFingersRight)
    {
        $this->articularExplorationSmallerFingersRight = $articularExplorationSmallerFingersRight;

        return $this;
    }

    /**
     * Get articularExplorationSmallerFingersRight
     *
     * @return string
     */
    public function getArticularExplorationSmallerFingersRight()
    {
        return $this->articularExplorationSmallerFingersRight;
    }

    /**
     * Set torsionsFemoralLeft
     *
     * @param string $torsionsFemoralLeft
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsFemoralLeft($torsionsFemoralLeft)
    {
        $this->torsionsFemoralLeft = $torsionsFemoralLeft;

        return $this;
    }

    /**
     * Get torsionsFemoralLeft
     *
     * @return string
     */
    public function getTorsionsFemoralLeft()
    {
        return $this->torsionsFemoralLeft;
    }

    /**
     * Set torsionsFemoralRight
     *
     * @param string $torsionsFemoralRight
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsFemoralRight($torsionsFemoralRight)
    {
        $this->torsionsFemoralRight = $torsionsFemoralRight;

        return $this;
    }

    /**
     * Get torsionsFemoralRight
     *
     * @return string
     */
    public function getTorsionsFemoralRight()
    {
        return $this->torsionsFemoralRight;
    }

    /**
     * Set torsionsGenusLeft
     *
     * @param string $torsionsGenusLeft
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsGenusLeft($torsionsGenusLeft)
    {
        $this->torsionsGenusLeft = $torsionsGenusLeft;

        return $this;
    }

    /**
     * Get torsionsGenusLeft
     *
     * @return string
     */
    public function getTorsionsGenusLeft()
    {
        return $this->torsionsGenusLeft;
    }

    /**
     * Set torsionsGenusRight
     *
     * @param string $torsionsGenusRight
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsGenusRight($torsionsGenusRight)
    {
        $this->torsionsGenusRight = $torsionsGenusRight;

        return $this;
    }

    /**
     * Get torsionsGenusRight
     *
     * @return string
     */
    public function getTorsionsGenusRight()
    {
        return $this->torsionsGenusRight;
    }

    /**
     * Set torsionsAngleQLeft
     *
     * @param string $torsionsAngleQLeft
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsAngleQLeft($torsionsAngleQLeft)
    {
        $this->torsionsAngleQLeft = $torsionsAngleQLeft;

        return $this;
    }

    /**
     * Get torsionsAngleQLeft
     *
     * @return string
     */
    public function getTorsionsAngleQLeft()
    {
        return $this->torsionsAngleQLeft;
    }

    /**
     * Set torsionsAngleQRight
     *
     * @param string $torsionsAngleQRight
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsAngleQRight($torsionsAngleQRight)
    {
        $this->torsionsAngleQRight = $torsionsAngleQRight;

        return $this;
    }

    /**
     * Get torsionsAngleQRight
     *
     * @return string
     */
    public function getTorsionsAngleQRight()
    {
        return $this->torsionsAngleQRight;
    }

    /**
     * Set torsionsTibialLeft
     *
     * @param string $torsionsTibialLeft
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsTibialLeft($torsionsTibialLeft)
    {
        $this->torsionsTibialLeft = $torsionsTibialLeft;

        return $this;
    }

    /**
     * Get torsionsTibialLeft
     *
     * @return string
     */
    public function getTorsionsTibialLeft()
    {
        return $this->torsionsTibialLeft;
    }

    /**
     * Set torsionsTibialRight
     *
     * @param string $torsionsTibialRight
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsTibialRight($torsionsTibialRight)
    {
        $this->torsionsTibialRight = $torsionsTibialRight;

        return $this;
    }

    /**
     * Get torsionsTibialRight
     *
     * @return string
     */
    public function getTorsionsTibialRight()
    {
        return $this->torsionsTibialRight;
    }

    /**
     * Set torsionsHelbingLeft
     *
     * @param string $torsionsHelbingLeft
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsHelbingLeft($torsionsHelbingLeft)
    {
        $this->torsionsHelbingLeft = $torsionsHelbingLeft;

        return $this;
    }

    /**
     * Get torsionsHelbingLeft
     *
     * @return string
     */
    public function getTorsionsHelbingLeft()
    {
        return $this->torsionsHelbingLeft;
    }

    /**
     * Set torsionsHelbingRight
     *
     * @param string $torsionsHelbingRight
     *
     * @return OrthopodologyHistory
     */
    public function setTorsionsHelbingRight($torsionsHelbingRight)
    {
        $this->torsionsHelbingRight = $torsionsHelbingRight;

        return $this;
    }

    /**
     * Get torsionsHelbingRight
     *
     * @return string
     */
    public function getTorsionsHelbingRight()
    {
        return $this->torsionsHelbingRight;
    }

    /**
     * Set dissimmetry
     *
     * @param string $dissimmetry
     *
     * @return OrthopodologyHistory
     */
    public function setDissimmetry($dissimmetry)
    {
        $this->dissimmetry = $dissimmetry;

        return $this;
    }

    /**
     * Get dissimmetry
     *
     * @return string
     */
    public function getDissimmetry()
    {
        return $this->dissimmetry;
    }

    /**
     * Set muscularExplorationDorsalFlexionLeft
     *
     * @param string $muscularExplorationDorsalFlexionLeft
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationDorsalFlexionLeft($muscularExplorationDorsalFlexionLeft)
    {
        $this->muscularExplorationDorsalFlexionLeft = $muscularExplorationDorsalFlexionLeft;

        return $this;
    }

    /**
     * Get muscularExplorationDorsalFlexionLeft
     *
     * @return string
     */
    public function getMuscularExplorationDorsalFlexionLeft()
    {
        return $this->muscularExplorationDorsalFlexionLeft;
    }

    /**
     * Set muscularExplorationDorsalFlexionRight
     *
     * @param string $muscularExplorationDorsalFlexionRight
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationDorsalFlexionRight($muscularExplorationDorsalFlexionRight)
    {
        $this->muscularExplorationDorsalFlexionRight = $muscularExplorationDorsalFlexionRight;

        return $this;
    }

    /**
     * Get muscularExplorationDorsalFlexionRight
     *
     * @return string
     */
    public function getMuscularExplorationDorsalFlexionRight()
    {
        return $this->muscularExplorationDorsalFlexionRight;
    }

    /**
     * Set muscularExplorationPlantarFlexionLeft
     *
     * @param string $muscularExplorationPlantarFlexionLeft
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationPlantarFlexionLeft($muscularExplorationPlantarFlexionLeft)
    {
        $this->muscularExplorationPlantarFlexionLeft = $muscularExplorationPlantarFlexionLeft;

        return $this;
    }

    /**
     * Get muscularExplorationPlantarFlexionLeft
     *
     * @return string
     */
    public function getMuscularExplorationPlantarFlexionLeft()
    {
        return $this->muscularExplorationPlantarFlexionLeft;
    }

    /**
     * Set muscularExplorationPlantarFlexionRight
     *
     * @param string $muscularExplorationPlantarFlexionRight
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationPlantarFlexionRight($muscularExplorationPlantarFlexionRight)
    {
        $this->muscularExplorationPlantarFlexionRight = $muscularExplorationPlantarFlexionRight;

        return $this;
    }

    /**
     * Get muscularExplorationPlantarFlexionRight
     *
     * @return string
     */
    public function getMuscularExplorationPlantarFlexionRight()
    {
        return $this->muscularExplorationPlantarFlexionRight;
    }

    /**
     * Set muscularExplorationEversionLeft
     *
     * @param string $muscularExplorationEversionLeft
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationEversionLeft($muscularExplorationEversionLeft)
    {
        $this->muscularExplorationEversionLeft = $muscularExplorationEversionLeft;

        return $this;
    }

    /**
     * Get muscularExplorationEversionLeft
     *
     * @return string
     */
    public function getMuscularExplorationEversionLeft()
    {
        return $this->muscularExplorationEversionLeft;
    }

    /**
     * Set muscularExplorationEversionRight
     *
     * @param string $muscularExplorationEversionRight
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationEversionRight($muscularExplorationEversionRight)
    {
        $this->muscularExplorationEversionRight = $muscularExplorationEversionRight;

        return $this;
    }

    /**
     * Get muscularExplorationEversionRight
     *
     * @return string
     */
    public function getMuscularExplorationEversionRight()
    {
        return $this->muscularExplorationEversionRight;
    }

    /**
     * Set muscularExplorationReversalLeft
     *
     * @param string $muscularExplorationReversalLeft
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationReversalLeft($muscularExplorationReversalLeft)
    {
        $this->muscularExplorationReversalLeft = $muscularExplorationReversalLeft;

        return $this;
    }

    /**
     * Get muscularExplorationReversalLeft
     *
     * @return string
     */
    public function getMuscularExplorationReversalLeft()
    {
        return $this->muscularExplorationReversalLeft;
    }

    /**
     * Set muscularExplorationReversalRight
     *
     * @param string $muscularExplorationReversalRight
     *
     * @return OrthopodologyHistory
     */
    public function setMuscularExplorationReversalRight($muscularExplorationReversalRight)
    {
        $this->muscularExplorationReversalRight = $muscularExplorationReversalRight;

        return $this;
    }

    /**
     * Get muscularExplorationReversalRight
     *
     * @return string
     */
    public function getMuscularExplorationReversalRight()
    {
        return $this->muscularExplorationReversalRight;
    }

    /**
     * Set dinamicExploration
     *
     * @param string $dinamicExploration
     *
     * @return OrthopodologyHistory
     */
    public function setDinamicExploration($dinamicExploration)
    {
        $this->dinamicExploration = $dinamicExploration;

        return $this;
    }

    /**
     * Get dinamicExploration
     *
     * @return string
     */
    public function getDinamicExploration()
    {
        return $this->dinamicExploration;
    }

    /**
     * Set signsFootprint
     *
     * @param string $signsFootprint
     *
     * @return OrthopodologyHistory
     */
    public function setSignsFootprint($signsFootprint)
    {
        $this->signsFootprint = $signsFootprint;

        return $this;
    }

    /**
     * Get signsFootprint
     *
     * @return string
     */
    public function getSignsFootprint()
    {
        return $this->signsFootprint;
    }

    /**
     * Set suplementaryTest
     *
     * @param string $suplementaryTest
     *
     * @return OrthopodologyHistory
     */
    public function setSuplementaryTest($suplementaryTest)
    {
        $this->suplementaryTest = $suplementaryTest;

        return $this;
    }

    /**
     * Get suplementaryTest
     *
     * @return string
     */
    public function getSuplementaryTest()
    {
        return $this->suplementaryTest;
    }

    /**
     * Set diagnostic
     *
     * @param string $diagnostic
     *
     * @return OrthopodologyHistory
     */
    public function setDiagnostic($diagnostic)
    {
        $this->diagnostic = $diagnostic;

        return $this;
    }

    /**
     * Get diagnostic
     *
     * @return string
     */
    public function getDiagnostic() { return $this->diagnostic; } 
	public function setTreatment($treatment) { $this->treatment = $treatment; return $this; } 
	public function getTreatment() { return $this->treatment; } 
	public function setRegistrationDate($registrationDate) { $this->registrationDate = $registrationDate; return $this; } 
	public function getRegistrationDate() { return $this->registrationDate; } 
	public function setModificationDate($modificationDate) { $this->modificationDate = $modificationDate; return $this; } 
	public function getModificationDate() { return $this->modificationDate; } 
	private $medicalHistory;
   	public function setMedicalHistory(\BackendBundle\Entity\MedicalHistory $medicalHistory = null) { $this->medicalHistory = $medicalHistory; return $this; } 
	public function getMedicalHistory() { return $this->medicalHistory; }
	private $userRegisterer;
	public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null) { $this->userRegisterer = $userRegisterer; return $this; } 
	public function getUserRegisterer() { return $this->userRegisterer; }
	private $userModifier;
	public function setUserModifier(\BackendBundle\Entity\User $userModifier = null) { $this->userModifier = $userModifier; return $this; }
	public function getUserModifier() { return $this->userModifier; }
/**************************************************************************************************************/
	/*
	 * la función __toString(){ return $this->gender;  } permite
	 * listar los campos cuando referenciemos la tabla
	 */
	public function __toString(){ return (string)$this->getMedicalHistory(); }
/**************************************************************************************************************/    
}

