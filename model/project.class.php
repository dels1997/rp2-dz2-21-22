<?php
class Project
{
    protected $id, $id_user, $title, $abstract, $number_of_members, $status;

    function __construct($id, $id_user, $title, $abstract, $number_of_members, $status)
    {
        $this->id = $id;
        $this->id_user = $id_user;
        $this->title = $title;
        $this->abstract = $abstract;
        $this->number_of_members = $number_of_members;
        $this->status = $status;
    }

    function __get($property)
    {
        if(property_exists($this, $property))
            return $this->$property;
    }

    function __set($property, $value)
    {
        if(property_exists($this, $property))
            $this->$property = $value;

        return $this;
    }
};

?>