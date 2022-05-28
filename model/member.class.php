<?php
class Member
{
    protected $id, $id_project, $id_user, $member_type;

    function __construct($id, $id_project, $id_user, $member_type)
    {
        $this->id = $id;
        $this->id_project = $id_project;
        $this->id_user = $id_user;
        $this->member_type = $member_type;
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