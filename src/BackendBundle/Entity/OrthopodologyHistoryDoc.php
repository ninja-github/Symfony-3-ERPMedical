<?php

namespace BackendBundle\Entity;

/**
 * OrthopodologyHistoryDoc
 */
class OrthopodologyHistoryDoc
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $doc;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $description;

    /**
     * @var \DateTime
     */
    private $registrationDate;

    /**
     * @var \DateTime
     */
    private $modificationDate;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $userRegisterer;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $userModifier;

    /**
     * @var \BackendBundle\Entity\OrthopodologyHistory
     */
    private $orthopodologyHistory;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set doc
     *
     * @param string $doc
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setDoc($doc)
    {
        $this->doc = $doc;

        return $this;
    }

    /**
     * Get doc
     *
     * @return string
     */
    public function getDoc()
    {
        return $this->doc;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set registrationDate
     *
     * @param \DateTime $registrationDate
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * Get registrationDate
     *
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * Set modificationDate
     *
     * @param \DateTime $modificationDate
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setModificationDate($modificationDate)
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * Get modificationDate
     *
     * @return \DateTime
     */
    public function getModificationDate()
    {
        return $this->modificationDate;
    }

    /**
     * Set idUserRegisterer
     *
     * @param \BackendBundle\Entity\User $idUserRegisterer
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setUserRegisterer(\BackendBundle\Entity\User $userRegisterer = null)
    {
        $this->userRegisterer = $userRegisterer;

        return $this;
    }

    /**
     * Get idUserRegisterer
     *
     * @return \BackendBundle\Entity\User
     */
    public function getUserRegisterer()
    {
        return $this->userRegisterer;
    }

    /**
     * Set idUserModifier
     *
     * @param \BackendBundle\Entity\User $idUserModifier
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setUserModifier(\BackendBundle\Entity\User $userModifier = null)
    {
        $this->userModifier = $userModifier;

        return $this;
    }

    /**
     * Get idUserModifier
     *
     * @return \BackendBundle\Entity\User
     */
    public function getUserModifier()
    {
        return $this->userModifier;
    }

    /**
     * Set idOrthopodologyHistory
     *
     * @param \BackendBundle\Entity\OrthopodologyHistory $idOrthopodologyHistory
     *
     * @return OrthopodologyHistoryDoc
     */
    public function setOrthopodologyHistory(\BackendBundle\Entity\OrthopodologyHistory $orthopodologyHistory = null)
    {
        $this->orthopodologyHistory = $orthopodologyHistory;

        return $this;
    }

    /**
     * Get idOrthopodologyHistory
     *
     * @return \BackendBundle\Entity\OrthopodologyHistory
     */
    public function getOrthopodologyHistory()
    {
        return $this->orthopodologyHistory;
    }
/* typeDoc *******************************************************************************************/
    private $typeDoc;
    public function setTypeDoc(\BackendBundle\Entity\TypeDoc $type = null) { $this->typeDoc = $type; return $this; }
    public function getTypeDoc() { return $this->typeDoc; }
/**************************************************************************************************************/    
}

