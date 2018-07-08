<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class Currency
{

    private $id;
    private $name;
    private $shortName;
    private $price;
    private $date;
    private $active;

    public function __construct(int $id,
                                string $name,
                                string $shortName,
                                float $price,
                                \DateTime $date,
                                bool $active )
    {
        $this->id = $id;
        $this->name = $name;
        $this->shortName = $shortName;
        $this->price = $price;
        $this->date = $date;
        $this->active = $active;
    }

    public function update(array $params)
    {
        $this->name = $params['name'] ?? $this->name;
        $this->shortName = $params['short_name'] ?? $this->shortName;
        $this->price = $params['actual_course'] ?? $this->price;
        $this->date = isset($params['actual_course_date']) ?
            \DateTime::createFromFormat('Y-m-d H-i-s',$params['actual_course_date']) :
            $this->date;
        $this->active = $params['active'] ?? $this->active;
        return $this;
    }

    /*  GETTERS SECTION*/
    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getShortName()
    {
        return $this->shortName;
    }

    public function getActualCourse()
    {
        return $this->price;
    }

    public function getActualCourseDate()
    {
        return $this->date;
    }

    public  function  isActive()
    {
        return $this->active;
    }

}