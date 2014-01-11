<?php

namespace Core\DatasBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * GathersStats
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class GathersStats
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
     * @ORM\Column(name="victims", type="string", length=255)
     */
    private $victims;


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
     * Set victims
     *
     * @param string $victims
     * @return GathersStats
     */
    public function setVictims($victims)
    {
        $this->victims = $victims;
    
        return $this;
    }

    /**
     * Get victims
     *
     * @return string 
     */
    public function getVictims()
    {
        return $this->victims;
    }
}
