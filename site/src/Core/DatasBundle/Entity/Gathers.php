<?php

namespace Core\DatasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Gathers
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Gathers
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
     * @var \DateTime
     *
     * @ORM\Column(name="datetime", type="datetime")
     */
    private $datetime;

    /**
     * @var string
     *
     * @ORM\Column(name="winscore", type="string", length=255)
     */
    private $winscore;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbplayers", type="integer")
     */
    private $nbplayers;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var integer
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var integer
     *
     * @ORM\Column(name="scorea", type="integer")
     */
    private $scorea;

    /**
     * @var integer
     *
     * @ORM\Column(name="scoreb", type="integer")
     */
    private $scoreb;


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
     * Set datetime
     *
     * @param \DateTime $datetime
     * @return Gathers
     */
    public function setDatetime($datetime)
    {
        $this->datetime = $datetime;
    
        return $this;
    }

    /**
     * Get datetime
     *
     * @return \DateTime 
     */
    public function getDatetime()
    {
        return $this->datetime;
    }

    /**
     * Set winscore
     *
     * @param string $winscore
     * @return Gathers
     */
    public function setWinscore($winscore)
    {
        $this->winscore = $winscore;
    
        return $this;
    }

    /**
     * Get winscore
     *
     * @return string 
     */
    public function getWinscore()
    {
        return $this->winscore;
    }

    /**
     * Set nbplayers
     *
     * @param integer $nbplayers
     * @return Gathers
     */
    public function setNbplayers($nbplayers)
    {
        $this->nbplayers = $nbplayers;
    
        return $this;
    }

    /**
     * Get nbplayers
     *
     * @return integer 
     */
    public function getNbplayers()
    {
        return $this->nbplayers;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Gathers
     */
    public function setPassword($password)
    {
        $this->password = $password;
    
        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status
     *
     * @param integer $status
     * @return Gathers
     */
    public function setStatus($status)
    {
        $this->status = $status;
    
        return $this;
    }

    /**
     * Get status
     *
     * @return integer 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set scorea
     *
     * @param integer $scorea
     * @return Gathers
     */
    public function setScorea($scorea)
    {
        $this->scorea = $scorea;
    
        return $this;
    }

    /**
     * Get scorea
     *
     * @return integer 
     */
    public function getScorea()
    {
        return $this->scorea;
    }

    /**
     * Set scoreb
     *
     * @param integer $scoreb
     * @return Gathers
     */
    public function setScoreb($scoreb)
    {
        $this->scoreb = $scoreb;
    
        return $this;
    }

    /**
     * Get scoreb
     *
     * @return integer 
     */
    public function getScoreb()
    {
        return $this->scoreb;
    }
}
