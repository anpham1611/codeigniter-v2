<?php

class Mhome extends MY_Model
{

    function _construct()
    {
        parent::_construct();

    }

    public function getLstArticles($key_search = null, $is_hot = false)
    {
        $arrRes = array();
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
            ->where(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ACTIVE, STATUS_1)
            ->limit(PAGING_NUMBER);

        if ($key_search != null && $key_search != '') {
            $this->db->where(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TITLE . ' LIKE "%' . $key_search . '%"');
        }

        if ($is_hot) {
            $this->db->order_by(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_VIEW_COUNT, 'DESC');
        } else {
            $this->db->order_by(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_CREATED_DATE, 'DESC');
        }

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $arrRes = $query->result();
        }

        return $arrRes;
    }

    public function getLstLoadMoreArticles($arr_ids, $key_search = null, $is_hot = false)
    {
        $arr_ids = explode(',', $arr_ids);
        $arrRes = array();

        if (count($arr_ids) > 0) {
            $this->db->select(
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ID . ' AS id,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_CREATED_DATE . ' AS created_date,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_MODIFIED_DATE . ' AS modified_date,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TITLE . ' AS title,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_DATA_WEBM . ' AS data_webm,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_DATA_MP4 . ' AS data_mp4,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_DATA_IMAGE . ' AS data_image,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TYPE . ' AS type,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_VIEW_COUNT . ' AS view_count,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_LIKE_COUNT . ' AS like_count,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TRANSLATE_COUNT . ' AS translate_count,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_COMMENT_COUNT . ' AS comment_count,' .
                ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ACTIVE . ' AS active,'
            )
                ->from(ArticlesModel::TBL_NAME)
                ->where(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ACTIVE, STATUS_1)
                ->where_not_in(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ID, $arr_ids)
                ->limit(PAGING_NUMBER);

            if ($key_search != null && $key_search != '') {
                $this->db->where(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_TITLE . ' LIKE "%' . $key_search . '%"');
            }

            if ($is_hot) {
                $this->db->order_by(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_VIEW_COUNT, 'DESC');
            } else {
                $this->db->order_by(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_CREATED_DATE, 'DESC');
            }

            $query = $this->db->get();
            if ($query->num_rows() > 0) {
                $arrRes = $query->result();
            }
        }

        return $arrRes;
    }

    public function insert_or_update_user($id, $avatar, $name, $email, $first_name, $middle_name, $last_name, $link, $birthday, $location, $hometown)
    {
        $can_add = true;

        $this->db->select(
            UsersModel::TBL_NAME . '.' . UsersModel::C_ID . ' AS id,'
        )
            ->from(UsersModel::TBL_NAME)
            ->where(UsersModel::TBL_NAME . '.' . UsersModel::C_ID, $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $can_add = false;
        }

        $data_fields = array(
            UsersModel::C_ID => $id,
            UsersModel::C_CREATED_DATE => date("Y-m-d H:i:s"),
            UsersModel::C_MODIFIED_DATE => date("Y-m-d H:i:s"),
            UsersModel::C_EMAIL => $email,
            UsersModel::C_AVATAR => $avatar,
            UsersModel::C_NAME => $name,
            UsersModel::C_FIRST_NAME => $first_name,
            UsersModel::C_MIDDLE_NAME => $middle_name,
            UsersModel::C_LAST_NAME => $last_name,
            UsersModel::C_LINK => $link,
            UsersModel::C_BIRTHDAY => $birthday,
            UsersModel::C_LOCATION => $location,
            UsersModel::C_HOMETOWN => $hometown
        );

        if ($can_add) {
            $this->db->insert(UsersModel::TBL_NAME, $data_fields);

        } else {
            unset($data_fields[UsersModel::C_ID]);
            unset($data_fields[UsersModel::C_CREATED_DATE]);
            $this->db->where(UsersModel::C_ID, $id);
            $this->db->update(UsersModel::TBL_NAME, $data_fields);
        }
    }

    /**
     * @param $data_fields
     * @param $field
     * @param $field_id
     * @param $table
     */
    function update_template($data_fields, $field, $field_id, $table)
    {
        $this->db->where($field, $field_id);
        $this->db->update($table, $data_fields);
    }

    /**
     * @param $field
     * @param $field_value
     * @param $table
     * @return bool
     */
    function select_tempate_where($field, $field_value, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field, $field_value);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * @param $field1
     * @param $field_value1
     * @param $field2
     * @param $field_value2
     * @param $table
     * @return bool
     */
    function select_tempate_basic_where2($field1, $field_value1, $field2, $field_value2, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $this->db->where($field2, $field_value2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * @param $field1
     * @param $field_value1
     * @param $table
     * @return bool
     */
    function select_tempate_basic_where1($field1, $field_value1, $table)
    {
        $this->db->select('*');
        $this->db->from($table);
        $this->db->where($field1, $field_value1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * @param $data_fields
     * @param $table
     */
    function insert_template($data_fields, $table)
    {
        $this->db->insert($table, $data_fields);
    }
}