<?php

namespace Core\ToolsBundle\Helper;

use Core\DatasBundle\Entity\School;

class SchoolPeriodHelper
{
    static function getCurrentPeriodBySchool(School $school)
    {
        $periods = self::getSchoolPeriods($school);
        $currentTime = new \DateTime();
        foreach ($periods as $period)
        {
            if ($currentTime->getTimestamp() >= $period->begin->getTimestamp() &&
                $currentTime->getTimestamp() <= $period->end->getTimestamp())
            {
                return $period;
            }
        }
        return end($periods);
    }
    
    static function getSchoolPeriods(School $school)
    {        
        $currentTime = new \DateTime();
        $yearBeginning = $school->getParameters()->getYearBeginning();
        $checkPoints = self::getSortedSchoolCheckPoints($school);
        $periods = array();
        foreach ($checkPoints as $key => $checkPoint)
        {
          $time = $checkPoint->getDate()->getTimestamp() - $yearBeginning->getTimestamp();
          $year = ($time < 0) ? ((int)$currentTime->format('Y')) : ((int)$currentTime->format('Y') - 1);
          $realCheckPoint = new \DateTime($year . $checkPoint->getDate()->format('-m-d'));

          $period = new \stdClass();
          $period->number = $key + 1;
          if ($key == 0)
              $period->begin = new \DateTime($year . $yearBeginning->format('-m-d'));
          else
          {
              $year = (((int)$realCheckPoint->format('m') - (int)$checkPoints[$key - 1]->getDate()->format('m')) < 0) ? ($year - 1) : ($year);
              $period->begin = new \DateTime($year . $checkPoints[$key - 1]->getDate()->format('-m-d'));
          }
          $period->end = $realCheckPoint;
          $periods[] = $period;
        }
        return $periods;
        
    }
    
    static function getSortedSchoolCheckPoints(School $school)
    {
        $yearBeginning = $school->getParameters()->getYearBeginning();
        $checkPoints = $school->getParameters()->getCheckPoints();
        $currentTime = new \DateTime();
        $inDisorder = true;
        while ($inDisorder)
        {
            $inDisorder = false;
            for ($i = 0; ($i < count($checkPoints) - 1); ++$i)
            {
                $time1 = $checkPoints[$i]->getDate()->getTimestamp() - $yearBeginning->getTimestamp();
                $time2 = $checkPoints[$i + 1]->getDate()->getTimestamp() - $yearBeginning->getTimestamp();          
                $year1 = ($time1 < 0) ? ((int)$currentTime->format('Y') + 1) : ((int)$currentTime->format('Y'));
                $year2 = ($time2 < 0) ? ((int)$currentTime->format('Y') + 1) : ((int)$currentTime->format('Y'));
                $cp1 = new \DateTime($year1 . $checkPoints[$i]->getDate()->format('-m-d'));
                $cp2 = new \DateTime($year2 . $checkPoints[$i + 1]->getDate()->format('-m-d'));
                if ($cp1->getTimestamp() > $cp2->getTimestamp())
                {
                    $tmpCp = $checkPoints[$i];
                    $checkPoints[$i] = $checkPoints[$i + 1];
                    $checkPoints[$i + 1] = $tmpCp;
                    $inDisorder = true;
                }
            }
        }
        return $checkPoints;
    }
    
    static function getMonthsElapsedBySchool(School $school)
    {
        $currentDate = new \DateTime();
        $schoolYearBegin = $user->getSchool()->getParameters()->getYearBeginning();
        $months = (int)$currentDate->format("m") - (int)$schoolYearBegin->format("m");
        if ($months < 0)
            $months += 12;
        return $months;
    }
}
