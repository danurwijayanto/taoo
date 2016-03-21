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

		function simpan_edit_perangkat($data){
			$query = "UPDATE data_perangkat SET nama_perangkat='$data[nama_perangkat]', ip_address='$data[ip_address]', lokasi='$data[lokasi]', community='$data[community]'
				WHERE id_perangkat=$data[id]";
	        $result = $this->db->query($query);
	        if($this->db->affected_rows() > 0){
	            return "Data Berhasil dipdate";
	        } else {
	            return $this->db->error;
	        }
		}

		function get_interface_active(){
			$query = "SELECT nama_interface, interface_index
				FROM  data_interface, data_ipaddress
				WHERE data_interface.interface_index=data_ipaddress.ip_addressindex AND data_interface.id_perangkat=data_ipaddress.id_perangkat GROUP BY nama_interface";

			#$query = "SELECT nama_interface FROM data_interface GROUP BY nama_interface";
			$result = $this->db->query($query);
	        return $result->result_array();
		}

		function get_data_if($data){
			$query = "SELECT *
				FROM  data_interface LEFT JOIN data_ipaddress
				ON data_interface.interface_index=data_ipaddress.ip_addressindex AND data_interface.id_perangkat=data_ipaddress.id_perangkat
				WHERE data_interface.id_perangkat=$data";
			$result = $this->db->query($query);
	        return $result->result_array();
		}

	}	
	/* End of file snmp_model.php */
	/* Location: ./application/models/squid_model.php */