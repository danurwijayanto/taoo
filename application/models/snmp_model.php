<?php

	Class SNMP_model extends CI_Model {	

		# End Fungsi untuk menghitung statistik popular site
		function get_alldev(){
			$query = "SELECT * FROM data_perangkat";
			$result = $this->db->query($query);

			return $result->result_array();
		}
	}	
	/* End of file snmp_model.php */
	/* Location: ./application/models/squid_model.php */