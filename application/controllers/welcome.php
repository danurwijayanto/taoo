<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		#$this->load->view('snmp');
		
		$data=array(
			'title'=>'Network Management System UPPTI FSM UNDIP',
			'isi' =>'admin/isi/home'
		);
		$this->load->view('admin/wrapper', $data);
	}

	public function log_squid(){
		$data=array(
			'title'=>'Network Management System UPPTI FSM UNDIP',
			'isi' =>'admin/isi/log_squid',
			'log_squid' => $this->squid_model->get_log()
		);
		$this->load->view('admin/wrapper', $data);
	}

	public function popular_site(){
		$data=array(
			'title'=>'Network Management System UPPTI FSM UNDIP',
			'isi' =>'admin/isi/popular_site',
			'pop_site' => $this->squid_model->popular_site(),
			'stats' => $this->squid_model->get_namaif() 
			// 'stats' => $this->squid_model->count_domaintuj() 
		);
		 $this->load->view('admin/wrapper', $data);
	}

	public function data_perangkat(){
		$data=array(
			'title'=>'Network Management System UPPTI FSM UNDIP',
			'isi' =>'admin/isi/data_perangkat',
			'data_perangkat' => $this->snmp_model->get_alldev()
		);
		$this->load->view('admin/wrapper', $data);
	}

	public function tambah_perangkat(){
		$data = array(
					'id_perangkat'=> '',
					'nama_perangkat' => $this->input->post('nama_perangkat'),
					'ip_address' => $this->input->post('ip'),
					'lokasi' => $this->input->post('lokasi'),
					'community' => $this->input->post('community'),
					'ver_snmp' => $this->input->post('ver')
				);
		$result=$this->snmp_model->simpan_perangkat($data);
		echo "<script type='text/javascript'>alert('".$result."')</script>";
		redirect('welcome/data_perangkat', 'refresh');
	}

	public function hapus_perangkat(){
		$data = $_GET['id'];
		$result=$this->snmp_model->hapus_perangkat($data);
		echo "<script type='text/javascript'>alert('".$result."')</script>";
		#redirect($this->agent->referrer(), 'refresh');
		redirect('welcome/data_perangkat', 'refresh');
	}

	public function get_perangkat(){
		$data = $_GET['id'];
		$result=$this->snmp_model->get_perangkat($data);
		echo json_encode($result);
	}

	public function simpan_edit_perangkat(){
		$data = array(
				'id' => $_GET['id'],
				'nama_perangkat' => $_POST['nama_perangkat'],
				'ip_address' => $_POST['ip_address'],
				'lokasi' => $_POST['lokasi'],
				'community' => $_POST['community'],
				'os' => $_POST['os'],
			);
		$result=$this->snmp_model->simpan_edit_perangkat($data);
	}

	public function scan_interface(){
		$id = $_GET['id'];
		$sess1 = $this->session->userdata('sess');

		$db = array(
				'id' => $id,
				'id_if' => snmpwalk($sess1['ip'], "public", ".1.3.6.1.2.1.2.2.1.1"),
				'nama_if' => snmpwalk($sess1['ip'], "public", ".1.3.6.1.2.1.2.2.1.2"),
				'status_if' => snmpwalk($sess1['ip'], "public", ".1.3.6.1.2.1.2.2.1.7"),
				'list_ip' => snmpwalk($sess1['ip'], "public", ".1.3.6.1.2.1.4.20.1.1"),
				'ip_index' => snmpwalk($sess1['ip'], "public", ".1.3.6.1.2.1.4.20.1.2")
			);
		$result=$this->snmp_model->simpan_scan_if($db);
		$result1=$this->snmp_model->simpan_scan_ip($db);
		echo "<script type='text/javascript'>alert('Perubahan Berhasil')</script>";
		redirect('welcome/data_perangkat', 'refresh');
	}


	public function detail_perangkat(){
		$id = $_GET['id'];
		$data = array(
				'title'=>'Network Management System UPPTI FSM UNDIP',
				'isi' =>'admin/isi/detail_perangkat',
				'detail' => $this->snmp_model->get_perangkat($id),
				'data_id' => $this->snmp_model->get_data_if($id)
					
		);
		foreach ($data['detail'] as $det) {
			$ip = $det["ip_address"];
			$os = $det["os"];
		}
		if ($os=="mikrotik"){
			$data['snmp'] = array(
				'totmem' => preg_replace("/[INTEGER:]/","",snmpget($ip, "public", ".1.3.6.1.2.1.25.2.3.1.5.65536"))
			);		
		}else{
			$data['snmp'] = array(
				'totmem' => preg_replace("/[INTEGER:]/","",snmpget($ip, "public", ".1.3.6.1.4.1.2021.4.5.0"))
			);
		}
		
		//Session untuk menyimpan data ip untuk digunakan di ajax
		$session_data = array(
				'ip'=> $ip,
				'os' => $os
		);
		//Mengeset nama session sebagai sess dengan data session_data
		$this->session->set_userdata('sess', $session_data);
		//End Session


		$this->load->view('admin/wrapper', $data);
	}

	public function statistik(){
		$data = array(
				'title'=>'Network Management System UPPTI FSM UNDIP',
				'isi' =>'admin/isi/statistik',
				'interface' => $this->snmp_model->get_interface_active()
		);
		$this->load->view('admin/wrapper', $data);
	}

	public function cari_statistik(){
		
		$post_data = array(
				'id_if' => $this->input->post('if'),
				'tawal' => $this->input->post('tanggal_awal'),
				'takhir' => $this->input->post('tanggal_akhir')
		);
		 // print_r($post_data['tawal']);
		$data = array(
				'title'=>'Network Management System UPPTI FSM UNDIP',
				'isi' =>'admin/isi/statistik',
				'interface' => $this->snmp_model->get_interface_active(),
				'statistik' => $this->squid_model->cari_statistik($post_data)
		);
		$this->load->view('admin/wrapper', $data);
	}

	public function detail_if(){
		$id = array(
				'id_if' => $this->input->get('id_if'),
				'id_per' => $this->input->get('id_per')
		);
		
		$data = array(
				'title'=>'Network Management System UPPTI FSM UNDIP',
				'isi' =>'admin/isi/detail_interface',
				'det_if' => $this->snmp_model->get_detail_if($id),
				#'statistik' => $this->squid_model->cari_statistik($id_if)
		);
		$this->load->view('admin/wrapper', $data);
	}

	//Fungsi ajax auto refresh
	public function uptime(){
		$sess = $this->session->userdata('sess');
		if ($sess['os']=="mikrotik") {
			$data = array(
				//'nama_perangkat' => snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.1.1.0"),
				'uptime' => snmpget($sess['ip'], "public", ".1.3.6.1.2.1.1.3.0"),
				'usedmem' => snmpget($sess['ip'], "public", ".1.3.6.1.2.1.25.2.3.1.6.65536"),
				'cpuload' => snmpget($sess['ip'], "public", ".1.3.6.1.2.1.25.3.3.1.2.1")
			);
		}else{
			$data = array(
				//'nama_perangkat' => snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.1.1.0"),
				'uptime' => snmpget($sess['ip'], "public", ".1.3.6.1.2.1.1.3.0"),
				'usedmem' => snmpget($sess['ip'], "public", ".1.3.6.1.4.1.2021.4.6.0"),
				'cpuload' => snmpget($sess['ip'], "public", ".1.3.6.1.4.1.2021.11.9.0")
			);
		}
		
		echo json_encode($data);
	}
	//End Fungsi Ajax auto refresh
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

