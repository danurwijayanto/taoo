<?php

	Class SNMP_model extends CI_Model {	

		
		function get_alldev(){
			$query = "SELECT * FROM data_perangkat";
			$result = $this->db->query($query);

			return $result->result_array();
		}

		function simpan_perangkat($data) {
			$query = $this->db->insert('data_perangkat',$data);
			if ($this->db->affected_rows() > 0) {
				return "Data Berhasil Ditambahkan";
			}else {
				return $this->db->error;
			}
		}

		function hapus_perangkat($data){
			$query = "DELETE FROM data_perangkat WHERE id_perangkat=$data";
	        $result = $this->db->query($query);
	        if($this->db->affected_rows() > 0){
	            return "Perangkat Berhasil dihapus";
	        } else {
	            return $this->db->error;
	        }
		}

		function get_perangkat($data){
			$query = "SELECT * FROM data_perangkat WHERE id_perangkat=$data";
	        $result = $this->db->query($query);
	        return $result->result_array();
		}
	}	
	/* End of file snmp_model.php */
	/* Location: ./application/models/squid_model.php */