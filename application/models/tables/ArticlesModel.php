<?php

class ArticlesModel extends CI_Model
{
    const TBL_NAME = 'articles';
    const C_ID = 'id';
    const C_CREATED_DATE = 'created_date';
    const C_MODIFIED_DATE = 'modified_date';
    const C_TITLE = 'title';
    const C_DATA_WEBM = 'data_webm';
    const C_DATA_MP4 = 'data_mp4';
    const C_DATA_IMAGE = 'data_image';
    const C_TYPE = 'type';
    const C_VIEW_COUNT = 'view_count';
    const C_LIKE_COUNT = 'like_count';
    const C_TRANSLATE_COUNT = 'translate_count';
    const C_COMMENT_COUNT = 'comment_count';
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