<?php

namespace Core\ToolsBundle\Twig\Extension;

class DateTimeExtension extends \Twig_Extension
{
    /**
     * French months
     * 
     * @var array 
     */
    private $months = array('Janvier', 'Février‎', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Août‎', 'Septembre', 'Octobre', 'Novembre', 'Décembre‎');
    
    /**
     * French days
     * 
     * @var array
     */
    private $days = array('Dimanche', 'Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi');
    
    /**
     * Error message (if date/datetime format is wrong)
     * 
     * @var string 
     */
    private $msgError = 'NC';
    
    /**
     * Date format
     * 
     * @var string 
     */
    private $dateFormat = '%s %02d %s %d';
    
    /**
     * Datetime format
     * 
     * @var string 
     */
    private $datetimeFormat = '%s %02d %s %d à %02dH%02d'; 

    /**
     * Returns the name of the extension.
     * 
     * @return string 
     */
    public function getName()
    {
        return 'dateTime';
    }
    
    /**
     * Returns a list of functions to add to the existing list.
     * 
     * @return array 
     */
    public function getFunctions()
    {
        return array(
            'dateConvertToFr' => new \Twig_Function_Method($this, 'dateConvert'),
            'durationConvert' => new \Twig_Function_Method($this, 'durationConvert')
        );
    }

    /**
     * Returns date converted
     * 
     * @param \Datetime $date
     * @param boolean $datetime
     * @param string $format
     * @param string $errorMsg
     * @return string
     */
    public function dateConvert($date, $datetime = false, $format = null, $errorMsg = null)
    {
        $this->msgError = ($errorMsg !== null) ? $errorMsg : $this->msgError;
        $format = ($format !== null) ? $fomat : (($datetime === true) ? $this->datetimeFormat : $this->dateFormat);
        
        if (($date instanceof \Datetime) === false) {
            return ($this->msgError);
        }
        
        $d = explode('-', $date->format('w-d-m-Y-H-i-s'));

        if ($datetime === true) {
            return (sprintf($format, $this->days[$d[0]], $d[1], $this->months[$d[2] - 1], $d[3], $d[4], $d[5]));
        }
        return (sprintf($format, $this->days[$d[0]], $d[1], $this->months[$d[2] - 1], $d[3]));
    }
    
    /**
     * Returns duration converted
     * 
     * @param integer $duration
     * @param string $mod
     * @param boolean $strictMod
     * @param array $format
     * @param string $errorMsg
     * @return string
     */
    public function durationConvert($duration, $mod, $strictMod = false, $format = array('H_MOD' => ' H', 'M_MOD' => ' Min'), $errorMsg = null)
    {
        $this->msgError = ($errorMsg !== null) ? $errorMsg : $this->msgError;
        
        if ($mod == 'H_MOD')
        {
            if ($strictMod === false) {
                return (($duration < 60) ? $duration . $format['M_MOD'] : ($duration / 60) . $format['H_MOD']);
            }
            else {
                return (($duration / 60) . $format['H_MOD']);
            }
        }
        elseif ($mod == 'M_MOD') {
            return ($duration . $format[$mod]);
        }
        else {
            return ($this->msgError);
        }
    }
}