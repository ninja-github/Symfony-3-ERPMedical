<?php

namespace BackendBundle\Entity;

/**
 * ScheduleGoogleCalendar
 */
class ScheduleGoogleCalendar
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var integer
     */
    private $refreshToken;

    /**
     * @var integer
     */
    private $googleCalendarId;

    /**
     * @var \BackendBundle\Entity\User
     */
    private $user;


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
     * Set refreshToken
     *
     * @param integer $refreshToken
     *
     * @return ScheduleGoogleCalendar
     */
    public function setRefreshToken($refreshToken)
    {
        $this->refreshToken = $refreshToken;

        return $this;
    }

    /**
     * Get refreshToken
     *
     * @return integer
     */
    public function getRefreshToken()
    {
        return $this->refreshToken;
    }

    /**
     * Set googleCalendarId
     *
     * @param integer $googleCalendarId
     *
     * @return ScheduleGoogleCalendar
     */
    public function setGoogleCalendarId($googleCalendarId)
    {
        $this->googleCalendarId = $googleCalendarId;

        return $this;
    }

    /**
     * Get googleCalendarId
     *
     * @return integer
     */
    public function getGoogleCalendarId()
    {
        return $this->googleCalendarId;
    }

    /**
     * Set user
     *
     * @param \BackendBundle\Entity\User $user
     *
     * @return ScheduleGoogleCalendar
     */
    public function setUser(\BackendBundle\Entity\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \BackendBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }
}
