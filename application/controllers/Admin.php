<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public $level;

    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('session');
        $this->db->query("SET sql_mode = '' ");

        if (!$this->session->has_userdata('hasLogin')) {
            redirect('login');
        } else
        if ($this->session->userdata('level') !== 'admin') {
            $level = $this->session->userdata('level');
            redirect("$level/");
        }
        $this->level = $this->session->userdata('level');
    }

    public function index()
    {
        $this->db->select("COUNT(a.nim) total, b.kategori");
        $this->db->from('tbl_sewa a');
        $this->db->join('tbl_kamar b', 'a.id_kamar = b.id', 'left');
        $this->db->where("a.status = 'Sukses'");
        $this->db->group_by('b.kategori');
        $get = $this->db->get()->result();

        $data = [];

        foreach ($get as $val) {
            $data['totalKategori'][$val->kategori] = $val->total;
        }

        $data['totalPenghuni'] = $this->Model->cekData('tbl_sewa', ['status' => 'Sukses']);
        $data['totalKamar'] = $this->Model->getTotalData('tbl_kamar');

        $this->load->view('admin/index', $data);
    }

    public function penghuni()
    {
        $data['TBL_URL'] = base_url('apiServer/penghuni');
        $this->load->view('admin/penghuni', $data);
    }

    public function sewa()
    {
        $data['TBL_URL'] = base_url('apiServer/sewa');
        $this->load->view('admin/sewa', $data);
    }

    public function laporan()
    {
        $this->load->view('admin/laporan');
    }

    public function kamar()
    {
        $this->load->view('admin/kamar');
    }
}
