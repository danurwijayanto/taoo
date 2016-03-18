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
				'community' => $_POST['community']
			);
		$result=$this->snmp_model->simpan_edit_perangkat($data);
	}

	public function detail_perangkat(){
		$data = array(
				'title'=>'Network Management System UPPTI FSM UNDIP',
				'isi' =>'admin/isi/detail_perangkat',
				'uptime' => snmpget("182.255.0.34", "public", ".1.3.6.1.2.1.1.3.0")
			);
		$this->load->view('admin/wrapper', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */

