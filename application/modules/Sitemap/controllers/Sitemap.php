<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sitemap extends MX_Controller {

	public function __construct()
	{
		parent::__construct();



	}
	public function index()
	{
		$data['data'] = array(

				0 => [

						'loc' => 'http://sodap.payakumbuhkota.go.id/Home/login/',
						'lastmod' => '2019-02-18T13:36:35+00:00',
						'title' => 'Login'
				],


    );

		$this->load->view('xml',$data);
	}
	public function html()
	{
		$data['title'] = 'Sodap';
    $data['link'] = 'http://sodap.payakumbuhkota.go.id';
		$data['data'] = array(

				0 => [

						'loc' => 'http://sodap.payakumbuhkota.go.id/Home/login/',
						'lastmod' => '2019-02-18T13:36:35+00:00',
						'title' => 'Login'
				],


		);
		$this->load->view('html',$data);
	}
	public function rdf()
	{
		$data['title'] = 'Sodap';
    $data['link'] = 'http://sodap.payakumbuhkota.go.id';
		$data['data'] = array(

				0 => [

						'loc' => 'http://sodap.payakumbuhkota.go.id/Home/login/',
						'lastmod' => '2019-02-18T13:36:35+00:00',
						'title' => 'Login'
				],


		);
		$this->load->view('ror-rdf',$data);
	}
}
