<?php
class v1_model extends CI_Model {
 
    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
        $this->load->database();
    }

  

    /**
    * Update user
    * @param array $data - associative array with data to store
    * @return boolean
    */
    function update_user($id, $data)
    {
		return $this->db->where('id', $id)->update('users', $data);
	}

    /**
    * Sql query run 
    * @param string $sql - sql query string
    * @return array
    */
    function get_result($sql)
    {
        $aresult = array();
        $query = $this->db->query($sql);
        foreach ($query->result_array() as $row)
        {
            $aresult[] = $row;
        }
        return $aresult;
    }

    /**
    * insert data
    * @param string $table - table name
    * @param array $data - data array to be insert
    * @return flag
    */
    function insert_data($table,$data)
    {
        if(!empty($table) && !empty($data)){
            return $this->db->insert($table, $data);
        }else{
            return false;
        }
    }

}
?>	
