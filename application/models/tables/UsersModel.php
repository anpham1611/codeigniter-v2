<?php

class UsersModel extends CI_Model
{
    const TBL_NAME = 'users';
    const C_ID = 'id';
    const C_CREATED_DATE = 'created_date';
    const C_MODIFIED_DATE = 'modified_date';
    const C_EMAIL = 'email';
    const C_AVATAR = 'avatar';
    const C_NAME = 'name';
    const C_FIRST_NAME = 'first_name';
    const C_MIDDLE_NAME = 'middle_name';
    const C_LAST_NAME = 'last_name';
    const C_LINK = 'link';
    const C_BIRTHDAY = 'birthday';
    const C_LOCATION = 'location';
    const C_HOMETOWN = 'hometown';
    const C_ACTIVE = 'active';

    function _construct()
    {
        parent::_construct();
    }

    /**
     *
     * @var Singleton
     */
    private static $instance;

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}