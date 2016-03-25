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
			$query = "UPDATE data_perangkat SET nama_perangkat='$data[nama_perangkat]', ip_address='$data[ip_address]', lokasi='$data[lokasi]', community='$data[community]', os='$data[os]'
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

		function simpan_scan_if($db){
			// Melakukan cek ke database
			// Apabila interface id tersebut sudah ada maka akan dilakukan delete dan insert kembali
			// Jika tidak ada akan langsung dilakukan insert
			$query_cek = "SELECT * FROM data_interface
							WHERE id_perangkat='$db[id]'";
			$result_cek = $this->db->query($query_cek);

			if($result_cek->num_rows() > 0){
	            $query_delete = "DELETE FROM data_interface
	            					WHERE id_perangkat='$db[id]'";
	            $result_delete = $this->db->query($query_delete);

	            // Fungsi untuk menambahkan ke database setelah data lama dihapus
	            $panjang_if = count($db['id_if']);
				$a = array();
				for ($i=0; $i<$panjang_if; $i++){
			
					$if_index =  trim(str_replace("INTEGER: ","",$db['id_if'][$i]));
					$if_name =  trim(str_replace("STRING: ","",$db['nama_if'][$i]));
					$if_status = trim(str_replace("INTEGER: ","",$db['status_if'][$i]));

					//Simpan ke database
					$query_add = "INSERT INTO data_interface (interface_index, nama_interface, status, id_perangkat)
			    				  VALUES ($if_index, '$if_name', '$if_status', $db[id])";

			    	$result_add = $this->db->query($query_add);			
				}

	            if($this->db->affected_rows() > 0){
	            	return "Data Interface Berhasil diperbaharui";
	        	} else {
	            	return $this->db->error;
	        	}
			}else {

				// return FALSE;
				$panjang_if = count($db['id_if']);
				$a = array();
				for ($i=0; $i<$panjang_if; $i++){
			
					$if_index =  trim(str_replace("INTEGER: ","",$db['id_if'][$i]));
					$if_name =  trim(str_replace("STRING: ","",$db['nama_if'][$i]));
					$if_status = trim(str_replace("INTEGER: ","",$db['status_if'][$i]));

					//Simpan ke database
					$query = "INSERT INTO data_interface (interface_index, nama_interface, status, id_perangkat)
			    				  VALUES ($if_index, '$if_name', '$if_status', $db[id])";

			    	$result = $this->db->query($query);			
				}
				if($this->db->affected_rows() > 0){
		            return "Data Interface Berhasil ditambahkan";
		        } else {
	            	return $this->db->error;
	       	 	}
			}
		}

		function simpan_scan_ip($db){
			// Melakukan cek ke database
			// Apabila IP id tersebut sudah ada maka akan dilakukan delete dan insert kembali
			// Jika tidak ada akan langsung dilakukan insert
			$query_cek = "SELECT * FROM data_ipaddress
							WHERE id_perangkat='$db[id]'";
			$result_cek = $this->db->query($query_cek);

			if($result_cek->num_rows() > 0){
	            $query_delete = "DELETE FROM data_ipaddress
	            					WHERE id_perangkat='$db[id]'";
	            $result_delete = $this->db->query($query_delete);

	            // Fungsi untuk menambahkan ke database setelah data lama dihapus
	            $panjang_ip = count($db['list_ip']);
				$a = array();
				for ($i=0; $i<$panjang_ip; $i++){

						//echo trim_er("IpAddress: ",$scan_ip['list_ip'][$i]).'||'.trim_er("INTEGER: ",$scan_ip['ip_index'][$i]).'<br>';
						$list_ipp = trim(str_replace("IpAddress: ","",$db['list_ip'][$i]));
						$ip_indexx = trim(str_replace("INTEGER: ","",$db['ip_index'][$i]));
					
						//Simpan ke database
						$query_add = "INSERT INTO data_ipaddress (id_perangkat, ip_address, ip_addressindex)
			    				VALUES ($db[id], '$list_ipp', $ip_indexx)";
						
			    	$result_add = $this->db->query($query_add);			
				}

	            if($this->db->affected_rows() > 0){
	            	return "Data IP Berhasil diperbaharui";
	        	} else {
	            	return $this->db->error;
	        	}
			}else {

				// Fungsi untuk menambahkan ke database setelah data lama dihapus
	            $panjang_ip = count($db['list_ip']);
				$a = array();
				for ($i=0; $i<$panjang_ip; $i++){

						//echo trim_er("IpAddress: ",$scan_ip['list_ip'][$i]).'||'.trim_er("INTEGER: ",$scan_ip['ip_index'][$i]).'<br>';
						$list_ipp = trim(str_replace("IpAddress: ","",$db['list_ip'][$i]));
						$ip_indexx = trim(str_replace("INTEGER: ","",$db['ip_index'][$i]));
					
						//Simpan ke database
						$query_add = "INSERT INTO data_ipaddress (id_perangkat, ip_address, ip_addressindex)
			    				VALUES ('$db[id]', '$list_ipp', '$ip_indexx')";
						
			    	$result_add = $this->db->query($query_add);			
				}

	            if($this->db->affected_rows() > 0){
	            	return "Data IP Berhasil diperbaharui";
	        	} else {
	            	return $this->db->error;
	        	}
			}
		}
	}	
	/* End of file snmp_model.php */
	/* Location: ./application/models/squid_model.php */