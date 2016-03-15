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
			'stats' => $this->squid_model->count_domaintuj()
		);
		$this->load->view('admin/wrapper', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */