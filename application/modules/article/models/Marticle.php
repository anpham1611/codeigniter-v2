<?php

class Marticle extends MY_Model
{

    function _construct()
    {
        parent::_construct();

    }

    public function getArticleDetail($id)
    {

        $this->db->where(ArticlesModel::C_ID, $id);
        $this->db->set(ArticlesModel::C_VIEW_COUNT, ArticlesModel::C_VIEW_COUNT . ' + 1', false);
        $this->db->update(ArticlesModel::TBL_NAME);

        $this->db->select(
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ID . ' AS id,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_CREATED_DATE . ' AS created_date,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_MODIFIED_DATE . ' AS modified_date,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TITLE . ' AS title,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_DATA_WEBM . ' AS data_webm,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_DATA_MP4 . ' AS data_mp4,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_DATA_IMAGE . ' AS data_image,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TYPE . ' AS type,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_VIEW_COUNT . ' AS view_count,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_LIKE_COUNT . ' AS like_count,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TRANSLATE_COUNT . ' AS translate_count,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_COMMENT_COUNT . ' AS comment_count,'.
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ACTIVE . ' AS active,'
        )
            ->from(ArticlesModel::TBL_NAME)
            ->where(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ID, $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

    public function insertOrUpdateTranslate($article_id, $title, $description)
    {
        $can_add = true;
        $user_id = $this->session->userdata(SESSION_USER_ID);
        $id = $article_id . '-' . $user_id;

        $this->db->select(
            TranslationsModel::TBL_NAME . '.' . TranslationsModel::C_ID . ' AS id,'
        )
            ->from(TranslationsModel::TBL_NAME)
            ->where(TranslationsModel::TBL_NAME . '.' . TranslationsModel::C_ID, $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $can_add = false;
        }

        $data_fields = array(
            TranslationsModel::C_ID => $id,
            TranslationsModel::C_CREATED_DATE => date("Y-m-d H:i:s"),
            TranslationsModel::C_MODIFIED_DATE => date("Y-m-d H:i:s"),
            TranslationsModel::C_USER_ID => $user_id,
            TranslationsModel::C_ARTICLE_ID => $article_id,
            TranslationsModel::C_TITLE => $title,
            TranslationsModel::C_DESCRIPTION => $description
        );

        if ($can_add) {
            $this->db->insert(TranslationsModel::TBL_NAME, $data_fields);

            // Update Translate count
            $this->db->where(ArticlesModel::C_ID, $article_id);
            $this->db->set(ArticlesModel::C_TRANSLATE_COUNT, ArticlesModel::C_TRANSLATE_COUNT . ' + 1', false);
            $this->db->update(ArticlesModel::TBL_NAME);

        } else {
            unset($data_fields[TranslationsModel::C_ID]);
            unset($data_fields[TranslationsModel::C_CREATED_DATE]);
            $this->db->where(TranslationsModel::C_ID, $id);
            $this->db->update(TranslationsModel::TBL_NAME, $data_fields);
        }
    }

    public function get_translate($article_id)
    {
        $user_id = $this->session->userdata(SESSION_USER_ID);
        $id = $article_id . '-' . $user_id;

        $this->db->select(
            TranslationsModel::TBL_NAME . '.' . TranslationsModel::C_ID . ' AS id,'.
            TranslationsModel::TBL_NAME . '.' . TranslationsModel::C_TITLE . ' AS title,'.
            TranslationsModel::TBL_NAME . '.' . TranslationsModel::C_DESCRIPTION . ' AS description,'
        )
            ->from(TranslationsModel::TBL_NAME)
            ->where(TranslationsModel::TBL_NAME . '.' . TranslationsModel::C_ID, $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }

        return null;
    }

}