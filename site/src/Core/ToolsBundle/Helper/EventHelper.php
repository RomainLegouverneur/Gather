<?php

namespace Core\ToolsBundle\Helper;
/**
 * Description of EventHelper
 *
 * @author Boris
 */
class EventHelper 
{
    public static $WEEK = 604800;
    
    public static function getJSONEvents($events, \DateTime $timeRef)
    {
        $datas = array();
        foreach ($events as $event)
        {
            $nbWeek = floor(($timeRef->getTimestamp() - $event->getDateBegin()->getTimestamp()) / self::$WEEK);
            $datas[] = array(
                'id' => $event->getId(),
                'start' => date(\DateTime::ISO8601, $event->getDateBegin()->getTimestamp() + ($nbWeek * self::$WEEK)),
                'end' => date(\DateTime::ISO8601, $event->getDateEnd()->getTimestamp() + ($nbWeek * self::$WEEK)),
                'title' => $event->getEventType()->getName() . (($event->getMatter()) ? (' de ' . $event->getMatter()->getName()) : ('')),
            );
        }
        return json_encode($datas);
    }
    
    public static function getDateTimeFromTime($time)
    {
        $time = substr($time, 0, strlen($time) - 3);   
        return (new \DateTime(date(\DateTime::ISO8601, $time)));
    }
    
    public static function getDateRangeFromRequest($request)
    {
        $range = new \stdClass();
        $range->start = self::getDateTimeFromTime($request->get('start'));
        $range->end = self::getDateTimeFromTime($request->get('end'));
        return $range;
    }
    
}

?>
