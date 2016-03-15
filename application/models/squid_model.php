<?php

	Class Squid_model extends CI_Model {	
		/**
			* Get Semua Log Squid 
		*/
		function get_log(){
			#$query = "SELECT * FROM squid_history";
			$query = "SELECT a.*, b.*, d.nama_perangkat, c.nama_interface FROM data_ipaddress as a RIGHT JOIN squid_history as b on SUBSTRING_INDEX(a.ip_address, '.', 3) = SUBSTRING_INDEX(b.user_ip, '.', 3) LEFT JOIN data_interface as c on a.ip_addressindex = c.interface_index LEFT JOIN data_perangkat as d on c.id_perangkat = d.id_perangkat";
	        $result = $this->db->query($query);
			return $result->result_array();
		}

		function popular_site(){
			$query = "SELECT domain_tujuan, count(*) as cnt FROM squid_history GROUP BY domain_tujuan ORDER BY cnt DESC";
	        $result = $this->db->query($query);
			return $result->result_array();
		}


		function select_userip(){
			$query = "SELECT user_ip FROM squid_history GROUP BY user_ip";
			$result = $this->db->query($query);
			return $result->result_array();
		}

		function count_domaintuj(){
			$hasil = array();
			$userip = $this->select_userip();
			$query_result = array();

			foreach ($userip as $ip) {
				$query = "SELECT domain_tujuan, user_ip, count(domain_tujuan) as cnt FROM squid_history 
						WHERE user_ip='$ip[user_ip]' GROUP BY domain_tujuan ORDER BY cnt DESC LIMIT 1";
				$result = $this->db->query($query);
				$result = $result->result_array();
				foreach ($result as $row){
					$query_result[] = array(
										$row['domain_tujuan'],
										$row['user_ip'],
										$row['cnt'],
									);
				}
			}	
			#print_r ($query_result);
			return  $query_result;
		}
	}	
	/* End of file squid_model.php */
	/* Location: ./application/models/squid_model.php */