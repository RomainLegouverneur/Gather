<?php

namespace Core\DatasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Servers
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class Servers
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
     * @ORM\Column(name="host", type="string", length=255)
     */
    private $host;

    /**
     * @var integer
     *
     * @ORM\Column(name="port", type="integer")
     */
    private $port;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxplayers", type="integer")
     */
    private $maxplayers;

    /**
     * @var string
     *
     * @ORM\Column(name="rconpassword", type="string", length=255)
     */
    private $rconpassword;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     */
    private $description;


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
     * Set host
     *
     * @param string $host
     * @return Servers
     */
    public function setHost($host)
    {
        $this->host = $host;
    
        return $this;
    }

    /**
     * Get host
     *
     * @return string 
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * Set port
     *
     * @param integer $port
     * @return Servers
     */
    public function setPort($port)
    {
        $this->port = $port;
    
        return $this;
    }

    /**
     * Get port
     *
     * @return integer 
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * Set maxplayers
     *
     * @param integer $maxplayers
     * @return Servers
     */
    public function setMaxplayers($maxplayers)
    {
        $this->maxplayers = $maxplayers;
    
        return $this;
    }

    /**
     * Get maxplayers
     *
     * @return integer 
     */
    public function getMaxplayers()
    {
        return $this->maxplayers;
    }

    /**
     * Set rconpassword
     *
     * @param string $rconpassword
     * @return Servers
     */
    public function setRconpassword($rconpassword)
    {
        $this->rconpassword = $rconpassword;
    
        return $this;
    }

    /**
     * Get rconpassword
     *
     * @return string 
     */
    public function getRconpassword()
    {
        return $this->rconpassword;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Servers
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
}
