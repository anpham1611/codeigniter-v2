<?php

class Mtrigger extends MY_Model
{

    function _construct()
    {
        parent::_construct();

    }

    public function insert_into_articles($id, $title, $data_image, $data_webm, $data_mp4, $type)
    {
        $can_add = true;

        $this->db->select(
            ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ID . ' AS id,'
        )
            ->from(ArticlesModel::TBL_NAME)
            ->where(ArticlesModel::TBL_NAME . '.' . ArticlesModel::C_ID, $id);

        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $can_add = false;
        }

        if ($can_add) {
            $data_fields = array(
                ArticlesModel::C_ID => $id,
                ArticlesModel::C_CREATED_DATE => date("Y-m-d H:i:s"),
                ArticlesModel::C_MODIFIED_DATE => date("Y-m-d H:i:s"),
                ArticlesModel::C_TITLE => $title,
                ArticlesModel::C_DATA_IMAGE => $data_image,
                ArticlesModel::C_DATA_WEBM => $data_webm,
                ArticlesModel::C_DATA_MP4 => $data_mp4,
                ArticlesModel::C_TYPE => $type
            );

            $this->db->insert(ArticlesModel::TBL_NAME, $data_fields);
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