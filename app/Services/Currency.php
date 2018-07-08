<?php

namespace App\Services;

class Currency extends PseudoModel
{
    protected $allowedAttributes = [
        'id',
        'name',
        'short_name',
        'actual_course',
        'actual_course_date',
        'active',
    ];

    //a bit experimental way to do this;
    public function __construct(int $id,
                                string $name,
                                string $shortName,
                                float $price,
                                \DateTime $date,
                                bool $active )
    {
        $this->modelData['id'] = $id;
        $this->modelData['name'] = $name;
        $this->modelData['short_name'] = $shortName;
        $this->modelData['actual_course'] = $price;
        $this->modelData['actual_course_date'] = $date;
        $this->modelData['active'] = $active;
    }

    public function getId()
    {
        return $this->modelData['id'];

    }

    public function getName()
    {
        return $this->modelData['name'];
    }

    public function getShortName()
    {
        return $this->modelData['short_name'];
    }

    public function getActualCourse()
    {
        return $this->modelData['actual_course'];
    }

    public function getActualCourseDate()
    {
        return $this->modelData['actual_course_date'];
    }

    public  function  isActive()
    {
        return $this->modelData['active'];
    }

}