<?php
class model extends CI_Model{
	public function validateUser($loginArray, $table)
	{		
		return $this->db->select('*')->from($table)->where($loginArray)->get()->num_rows(); 
	}
public function search()
{
	$keyword=$_POST['keyword'];
	$this->db->select('* from user');
	$this->db->like('username','%".$keyword."%');
	$query=$this->db->get();
	return $query->result();
}
public function status()
{
	$this->db->select(' count(voteid) as id,candidateid,candidate_name,sum(rate) as rate,status from vote');
	$this->db->where('status',1);
	$this->db->group_by('candidateid');
	$query=$this->db->get();
	return $query->result();

}
public function id()
{
	$this->db->select('id from user');
	$this->db->where('user_type','user');
	$this->db->order_by('id','desc');
	$query=$this->db->get();
	return $query->row();
}

public function link()
{
	$this->db->select('status  from vote');
	$this->db->where('status',1);
	$this->db->group_by('status');
	$query=$this->db->get();
	return $query->result();
}

	public function fetchRows($table,$fields=NULL,$condition=NULL,$extra=NULL)
	{
		if($extra==NULL)
		{
			if($condition != NULL && $fields != NULL)
			{				
				 $this->db->select($fields)->from($table)->where($condition);
				 $result11 = $this->db->get();	
				 return($result11->result_array());
			}
			if($condition == NULL && $fields != NULL)
			{
				return $this->db->select($fields)->from($table)->get()->result_array();
			}
			if($condition != NULL && $fields == NULL)
			{
				$this->db->select('*')->from($table)->where($condition);
				$result11 = $this->db->get();
			 	return($result11->result_array());
			}
			if($condition == NULL && $fields == NULL)
			{			
				$qr=  $this->db->get($table)->result_array();
				return $qr;
			}
		}
		else 
		{
			if($condition != NULL && $fields != NULL)
			{
				
				$this->db->select($fields)->from($table)->where($condition)->order_by($extra);
				$result11 = $this->db->get();
				return($result11->result_array());
			}
			if($condition == NULL && $fields != NULL)
			{
				$this->db->select($fields)->from($table)->order_by($extra);
				$result11 = $this->db->get();
				return($result11->result_array());
			}
			if($condition != NULL && $fields == NULL)
			{
				$this->db->select('*')->from($table)->where($condition);
				$result11 = $this->db->get();
			 	return($result11->result_array());
			}
			if($condition == NULL && $fields == NULL)
			{	$this->db->order_by($extra);
			    	$qr=  $this->db->get($table)->result_array();
				return $qr;
			}
		}
		
	}
	public function fetchRowOrderby($table,$spec=NULL,$condition=NULL,$extra=NULL)
	{
		$this->db->select('*'); 
			$this->db->from($table);
			foreach($extra as $key=>$v)
			{
				$this->db->join($key,$v,'INNER');
			}
			$this->db->where($condition);
			$this->db->order_by($spec);
			$query = $this->db->get();
			return($query->result_array());
	}
	public function fetchRowsno($table,$fields=NULL,$condition=NULL,$extra=NULL)
	{
		if($condition != NULL && $fields != NULL)
		{
			return $this->db->select($fields)->from($table)->where_not_in($condition,$extra)->get()->result_array();	
		}
		if($condition != NULL && $fields == NULL)
		{
			$this->db->select('*')->from($table)->where_not_in($condition,$extra);
			$result11 = $this->db->get();
		 	return($result11->result_array());
		}
	}
	public function fetchRowJoin($table,$condition=NULL,$extra=NULL)
	{
		if($condition==NULL)
		{
			$this->db->select('*')->from($table);
			foreach($extra as $key=>$v)
			{
			$this->db->join($key,$v,'INNER');
			}
			$query = $this->db->get();
			return($query->result_array());		
		}
		else
		{
			$this->db->select('*'); 
			$this->db->from($table);
			foreach($extra as $key=>$v)
			{
				$this->db->join($key,$v,'INNER');
			}
			$this->db->where($condition);
			$query = $this->db->get();
			return($query->result_array());
		}	
	}


	 public function fetchRowsLike($table,$fields = NULL,$target = NULL,$item = NULL , $condition = NULL )
	 {
	    if($table!= NULL && $fields != NULL && $target != NULL && $item != NULL && $condition != NULL)
	    	{
	    		$this->db->select($fields);
				$this->db->like($target, $item);
				$this->db->from($table);
				$this->db->where($condition);
				$query = $this->db->get();
				return($query->result_array());
			}

		elseif($table!= NULL && $fields != NULL && $target != NULL && $item != NULL && $condition == NULL)
	    	{
	    		$this->db->select($fields);
				$this->db->like($target, $item);
				$this->db->from($table);
				$query = $this->db->get();
				return($query->result_array());
			}


		return(0);
	 }




	 public function fetchSum($table,$fields,$condn)
	 {
	     $this->db->select_sum($fields)->from($table)->where($condn);
	     $er=$this->db->get();
	     return $er->result_array();
	 }
	 
	public function insertEntry($table,$fields)
	{		
		return $this->db->insert($table,$fields);
	}
	public function updateEntry($fieldValues,$table,$condition)
	{
		return $this->db->update($table, $fieldValues, $condition);	
	}
	public function deleteRows($table, $condition)
	{
		return $this->db->delete($table,$condition); 
	}
	public function fetchJoinSpec($table,$condition=NULL,$extra=NULL,$type=NULL,$fields=NULL)
	{		
		if($condition==NULL)
		{
			if($type=='groupby')
			{
				$this->db->select('*');    
				$this->db->from($table);
				foreach($extra as $key=>$v)
				{
					$this->db->join($key,$v,'INNER');
				}
				$this->db->group_by($fields); 						
				$query = $this->db->get();
		  		return($query->result_array());
			}
		}
		else 
		{
			if($type=='groupby')
			{
				$this->db->select('*');    
				$this->db->from($table);
				foreach($extra as $key=>$v)
				{
					$this->db->join($key,$v,'INNER');
				}
				$this->db->where($condition);
				$this->db->group_by($fields); 	
				$query = $this->db->get();
		  		return($query->result_array());
			}
			
		}
	}
	
	public function fetchCalc($table,$condition=NULL,$fld=NULL,$type=NULL,$fields=NULL)
	{		
		if($type=='groupby')
		{
			$this->db->select($fld);    
			$this->db->from($table);

			if($condition){

			$this->db->where($condition);
		}

			$this->db->group_by($fields); 	
			$query = $this->db->get();
			return($query->result_array());					
		}
	}
	function get_productcode($q)
	{
		$this->db->select('Product_Code');
		$this->db->like('Product_Code', $q);
		$query = $this->db->get('Product_Master');
		if($query->num_rows > 0){
			foreach ($query->result_array() as $row){
				$row_set[] = htmlentities(stripslashes($row['Product_Code'])); //build an array
			}
			echo json_encode($row_set); //format the array into json data
		}
	}
	function get_customer($q){
		$this->db->select('Customer_Name');
		$this->db->like('Customer_Name', $q);
		$query = $this->db->get('Customer_Master');
		if($query->num_rows > 0){
			foreach ($query->result_array() as $row){
				$row_set[] = htmlentities(stripslashes($row['Customer_Name'])); //build an array
			}
			echo json_encode($row_set); //format the array into json data
		}
	}

}
?>
