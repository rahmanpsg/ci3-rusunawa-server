<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Biro extends CI_Controller
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
        if ($this->session->userdata('level') !== 'biro') {
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

        $this->load->view('biro/index', $data);
    }

    public function laporan()
    {
        $this->load->view('biro/laporan');
    }
}
