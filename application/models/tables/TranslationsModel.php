<?php

class TranslationsModel extends CI_Model
{
    const TBL_NAME = 'translations';
    const C_ID = 'id';
    const C_CREATED_DATE = 'created_date';
    const C_MODIFIED_DATE = 'modified_date';
    const C_USER_ID = 'user_id';
    const C_ARTICLE_ID = 'article_id';
    const C_TITLE = 'title';
    const C_DESCRIPTION = 'description';
    const C_LIKE_COUNT = 'like_count';
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