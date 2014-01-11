<?php

namespace Core\DatasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Players
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Players
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
     * @var boolean
     *
     * @ORM\Column(name="team", type="boolean")
     */
    private $team;

    /**
     * @var integer
     *
     * @ORM\Column(name="accesslvl", type="integer")
     */
    private $accesslvl;


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
     * Set team
     *
     * @param boolean $team
     * @return Players
     */
    public function setTeam($team)
    {
        $this->team = $team;
    
        return $this;
    }

    /**
     * Get team
     *
     * @return boolean 
     */
    public function getTeam()
    {
        return $this->team;
    }

    /**
     * Set accesslvl
     *
     * @param integer $accesslvl
     * @return Players
     */
    public function setAccesslvl($accesslvl)
    {
        $this->accesslvl = $accesslvl;
    
        return $this;
    }

    /**
     * Get accesslvl
     *
     * @return integer 
     */
    public function getAccesslvl()
    {
        return $this->accesslvl;
    }
}
