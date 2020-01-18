<?php

/* Utility class for better access to Database
   All the other models extends from MyModel */
   
class MyModel extends CI_Model {
	
    public function getById($id) {
		
		$element = null;
				
		$query = $this->db->get_where($this->table, array(
            'id' => $id,
        ));

		if ($query->num_rows() > 0) {
            $element = $query->row_array();
		}
	
		return $element;
    }	

    public function getWhere($where = array(), $options = array(), $limit = 9999, $page = 0) {
		
		$elements = array();

		if ( isset($options['orderby']) ){
            $aux = explode(' ', $options['orderby']);
            $this->db->order_by($aux[0], $aux[1]);
		}	
		
				
		$query = $this->db->get_where($this->table, $where, $limit, ($page*$limit));
		
		foreach ($query->result_array() as $row) {
            $elements[] = $row;
		}
		
		return $elements;	
    }
	
	public function getPaginated($offset = 0, $limit = 30, $where = array(), $options = array()){
		
		$items = array();
		
		if ( isset($options['orderby']) ){
            $aux = explode(' ', $options['orderby']);
            $this->db->order_by($aux[0], $aux[1]);
		}
		else {
			$this->db->order_by('id', 'ASC');
		}
		
		$query = $this->db->get_where($this->table, $where, $limit, $offset);
		foreach ($query->result_array() as $row){
        	$items[] = $row;
		}
		
		
		return $items;
	}


	public function getQuery($query){
		$elements = array();
		
		$results = $this->db->query($query);
		foreach ( $results->result_array() as $row ){
			$elements[] = $row;
		}
		return $elements;
	}

	public function getList( $options = array() ){
		
		$datos = array();
		$where = array();
		
		if ( isset($options['where']) ){
			$where = $options['where']; 
		}
		
		if ( isset($options['orderby']) ){
            $aux = explode(' ', $options['orderby']);
            $this->db->order_by($aux[0], $aux[1]);
		}
		
		$query = $this->db->get_where( $this->table, $where );

		foreach ($query->result_array() as $row){
			$datos[ $row->id ] = $row;
		}
		
		
		return($datos);
	}

	function getEnumValues( $field ) {
		
		$type = $this->db->query( "SHOW COLUMNS FROM {$this->table} WHERE Field = '{$field}'" )->row( 0 )->Type;
		preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
		
		$enum = explode("','", $matches[1]);
    
		return $enum;
	}

}

