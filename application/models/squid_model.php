<?php

	Class Squid_model extends CI_Model {	
		/**
			* Get Semua Log Squid 
		*/
		function get_log(){
			#$query = "SELECT * FROM squid_history";
			$query = "SELECT a.*, b.*, d.nama_perangkat, c.nama_interface 
						FROM data_ipaddress as a RIGHT JOIN squid_history as b 
						on SUBSTRING_INDEX(a.ip_address, '.', 3) = SUBSTRING_INDEX(b.user_ip, '.', 3) 
						LEFT JOIN data_interface as c on a.ip_addressindex = c.interface_index 
						LEFT JOIN data_perangkat as d on c.id_perangkat = d.id_perangkat";
	        $result = $this->db->query($query);
			return $result->result_array();
		}

		function popular_site(){
			#$query = "SELECT domain_tujuan, count(*) as cnt FROM squid_history GROUP BY domain_tujuan ORDER BY cnt DESC";
	        $query = "SELECT domain_tujuan FROM squid_history";
	        $result = $this->db->query($query);
			return $result->result_array();
		}

		# Start Fungsi untuk menghitung statistik popular site
		function select_userip(){
			$query = "SELECT user_ip FROM squid_history GROUP BY user_ip";
			$result = $this->db->query($query);
			return $result->result_array();
		}

		function count_domaintuj(){
			#$hasil = array();
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

		function get_namaif(){
			$userip2 = $this->count_domaintuj();
			$query_result = array();
			
			foreach ($userip2 as $ip) {
				$query = "SELECT a.nama_interface FROM data_interface  as a , data_ipaddress as b
						WHERE SUBSTRING_INDEX('$ip[1]', '.', 3)=SUBSTRING_INDEX(b.ip_address, '.', 3) AND b.ip_addressindex=a.interface_index";
				$result = $this->db->query($query);
				$result = $result->result_array();
				#print_r ($result);
				foreach ($result as $row){
					$query_result[] = array(
										'domain' => $ip[0],
										'ip_asal' => $ip[1],
										'hit' => $ip[2],
										'nama_if' => $row['nama_interface']
									);
				}
			}	
			#print_r ($query_result);
			return  $query_result;
		}
		# End Fungsi untuk menghitung statistik popular site

		function cari_statistik($data){
			$query = "SELECT domain_tujuan, nama_interface FROM data_interface as a, data_ipaddress as b, squid_history as c
					WHERE a.interface_index=b.ip_addressindex and SUBSTRING_INDEX(c.user_ip, '.', 3)=SUBSTRING_INDEX(b.ip_address, '.', 3) and a.interface_index = $data";

			$result = $this->db->query($query);
			return $result->result_array();
		}
	}	
	/* End of file squid_model.php */
	/* Location: ./application/models/squid_model.php */