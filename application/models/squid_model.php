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
			$domhit = array();
			$domhit_fix = array();

			function url($data){
			    //GETTING DOMAIN USING PREG MATCH
			    // get host name from URL
			    preg_match('@^(?:http://)?([^/]+)@i', $data, $matches); $host = $matches[1];

			    // get last two segments of host name
			    preg_match('/[^.]+\.[^.]+$/', $host, $matches); 
			    return $domain = $matches[0];

			  }

			foreach ($userip as $ip) {
				// $query = "SELECT domain_tujuan, user_ip, count(domain_tujuan) as cnt FROM squid_history 
				// 		WHERE user_ip='$ip[user_ip]' GROUP BY domain_tujuan ORDER BY cnt DESC LIMIT 1";
				// $result = $this->db->query($query);
				// $result = $result->result_array();
				// foreach ($result as $row){
				// $query_result[] = array(
				// 						$row['domain_tujuan'],
				// 						$row['user_ip'],
				// 						$row['cnt'],
				// 					);
				// }
				// TEST QUERY
				$query = "SELECT domain_tujuan, user_ip FROM squid_history 
						WHERE user_ip='$ip[user_ip]'";
				$result = $this->db->query($query);
				$result = $result->result_array();

				foreach ($result as $pop) {  
	                //Memasukkak ke array baru    
	                array_push($domhit,url($pop['domain_tujuan']));
              	}
              	//Menghitung Jumlah Value Array yang Sama
              	$domhit = array_count_values($domhit);
				
				//Sort Array (Descending Order), According to Value - arsort()
              	arsort($domhit);
              	// print_r($domhit);
              	//membuat Array dengan Index dan Mengambil array pertama
              	// $i=0;
              	foreach ($domhit as $dom => $cnt) {
              	 	$domhit_fix[]=array(
              	 					$dom, 
              	 					$cnt
              	 				);
              		// if ($i==1){
              		// 	break;
              		// }else{
              		// 	$domain = $dom;
              		// 	$cnt = $cnt;
              		// }
              		
              		// // break;
              		// $i++;
              	 }
              	 // $domain  = 
				// print_r($domhit_fix[0][0]);


				// foreach ($userip as $row){
				$query_result[] = array(
									// $row['domain_tujuan'],
									$domhit_fix[0][0],
									$ip['user_ip'],
									$domhit_fix[0][1]
									// $row['cnt'], DOMHIT
								);
				// }	
				// Unset Array
				unset($domhit);
				unset($domhit_fix);
				$domhit = array();
				$domhit_fix = array();
			}	

			// print_r ($query_result);
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
			// print_r ($query_result);
			return  $query_result;
		}
		# End Fungsi untuk menghitung statistik popular site

		// Controller welcome/cari_statistik
		function cari_statistik($data){
			// print_r($data['tawal']);

			$query = "SELECT domain_tujuan, nama_interface FROM data_interface as a, data_ipaddress as b, squid_history as c
					WHERE a.interface_index=b.ip_addressindex and SUBSTRING_INDEX(c.user_ip, '.', 3)=SUBSTRING_INDEX(b.ip_address, '.', 3) and a.interface_index = $data[id_if] and (DATE(c.waktu) BETWEEN '$data[tawal]' AND '$data[takhir]')";

			$result = $this->db->query($query);
			return $result->result_array();
		}
	}	
	/* End of file squid_model.php */
	/* Location: ./application/models/squid_model.php */