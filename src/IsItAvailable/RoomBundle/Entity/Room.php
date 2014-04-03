<?php

namespace IsItAvailable\RoomBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Room
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="IsItAvailable\RoomBundle\Entity\RoomRepository")
 */
class Room
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="status_url", type="string", length=255)
     */
    private $statusUrl;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean")
     */
    private $status = false;

    /**
     * @var string
     *
     * @ORM\Column(name="calendar_url", type="string", length=255)
     */
    private $calendarUrl;

    /**
     * @var integer
     *
     * @ORM\OneToOne(targetEntity="Event", mappedBy="room")
     */
    private $nextEvent;


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
     * Set name
     *
     * @param string $name
     * @return Room
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set statusUrl
     *
     * @param string $statusUrl
     * @return Room
     */
    public function setStatusUrl($statusUrl)
    {
        $this->statusUrl = $statusUrl;

        return $this;
    }

    /**
     * Get statusUrl
     *
     * @return string
     */
    public function getStatusUrl()
    {
        return $this->statusUrl;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Room
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set calendarUrl
     *
     * @param string $calendarUrl
     * @return Room
     */
    public function setCalendarUrl($calendarUrl)
    {
        $this->calendarUrl = $calendarUrl;

        return $this;
    }

    /**
     * Get calendarUrl
     *
     * @return string
     */
    public function getCalendarUrl()
    {
        return $this->calendarUrl;
    }

    /**
     * Set nextEvent
     *
     * @param \IsItAvailable\RoomBundle\Entity\Event $nextEvent
     * @return Room
     */
    public function setNextEvent(\IsItAvailable\RoomBundle\Entity\Event $nextEvent = null)
    {
        $this->nextEvent = $nextEvent;

        return $this;
    }

    /**
     * Get nextEvent
     *
     * @return \IsItAvailable\RoomBundle\Entity\Event
     */
    public function getNextEvent()
    {
        return $this->nextEvent;
    }

    public function toArray()
    {
        return array(
            'nextEvent' => $this->nextEvent->toArray(),
            'name' => $this->name,
            'status' => $this->status,
        );
    }
}
