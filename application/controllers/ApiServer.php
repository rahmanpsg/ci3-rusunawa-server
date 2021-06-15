<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, DELETE, PUT');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');

defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

class ApiServer extends RestController
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Model');
        $this->load->library('session');
        $this->db->query("SET sql_mode = '' ");
    }

    public function login_post()
    {
        $username = $this->post('username');
        $password = $this->post('password');

        if ($username === null || $password === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->select('level');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $cek = $this->db->get('tbl_admin');

        if ($cek->num_rows() > 0) {
            $data = $cek->result()[0];
            $session = ['hasLogin' => true, 'level' => $data->level];
            $this->session->set_userdata($session);
            $this->response(['error' => false, 'message' => "Anda berhasil login", 'level' => $data->level], 200);
        }

        $this->response(['error' => true, 'message' => 'Username atau password salah'], 200);
    }
    // -------------------------------------------------------------------------------------------------------------------
    public function penghuniKamar_get()
    {
        $id = $this->get('id');

        if ($id === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->select('a.nim, a.tanggal_masuk, a.tanggal_keluar, b.nama, b.foto');
        $this->db->from('tbl_sewa a');
        $this->db->join('tbl_user b', 'a.nim = b.nim', 'left');
        $this->db->where('a.id_kamar', $id);
        $this->db->where('a.status', 'Sukses');
        $data = $this->db->get()->result();

        $this->response($data, 200);
    }
    // -------------------------------------------------------------------------------------------------------------------
    public function penghuni_get()
    {
        $this->db->select("nim, nama, jurusan, telp, jenis_kelamin, foto, DATE_FORMAT(tgl_lahir, '%d-%c-%Y') tgl_lahir, detail");
        $get = $this->db->get('tbl_user')->result();

        $data = array_map(function ($v) {
            $v->nama = ucwords($v->nama);
            $v->jurusan = ucwords($v->jurusan);
            $v->detail = json_decode($v->detail);

            $this->db->select("a.id, a.tanggal_masuk, a.tanggal_keluar, b.nomor, b.lantai, b.tipe");
            $this->db->from('tbl_sewa a');
            $this->db->join('tbl_kamar b', 'a.id_kamar = b.id', 'left');
            $this->db->where(['nim' => $v->nim, 'status' => 'Sukses']);
            $v->dataSewa = $this->db->get()->result();
            return $v;
        }, $get);

        $this->response($data, 200);
    }
    // -------------------------------------------------------------------------------------------------------------------
    public function kamar_post()
    {
        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }

        // $data['attribut'] = json_encode($data['attribut']);

        $simpan = $this->db->insert('tbl_kamar', $data);

        if ($simpan) {
            $this->response(['error' => false, 'message' => 'Kamar berhasil disimpan'], 200);
        }
        $this->response(['error' => true, 'message' => 'Kamar gagal disimpan'], 200);
    }
    public function deleteKamar_post()
    {
        $id = $this->post('id');

        if ($id === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $hapus = $this->db->delete('tbl_kamar', ['id' => $id]);

        if ($hapus) {
            $this->response(['error' => false, 'message' => 'Kamar berhasil dihapus'], 200);
        }
        $this->response(['error' => true, 'message' => 'Kamar gagal dihapus'], 200);
    }
    public function updateKamar_post()
    {
        $id = $this->post('id');

        if ($id === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        foreach ($_POST as $key => $value) {
            $data[$key] = $value;
        }

        $update = $this->db->update('tbl_kamar', $data, ['id' => $id]);

        if ($update) {
            $this->response(['error' => false, 'message' => 'Kamar berhasil diubah'], 200);
        }
        $this->response(['error' => true, 'message' => 'Kamar gagal diubah'], 200);
    }
    // -------------------------------------------------------------------------------------------------------------------
    public function sewa_get()
    {
        $this->db->select("a.id, a.nim, a.tanggal_masuk, a.tanggal_keluar, a.pembayaran, IF(DATE_ADD(a.ditambahkan_pada, INTERVAL 1 DAY) <= NOW(), 'Expired', a.status) as status, a.ditambahkan_pada, CONCAT('Rp ', FORMAT(total_bayar, 0)) as total_bayar, b.nama, c.nomor, c.lantai, c.kategori");
        $this->db->from('tbl_sewa a');
        $this->db->join('tbl_user b', 'a.nim = b.nim', 'left');
        $this->db->join('tbl_kamar c', 'a.id_kamar = c.id', 'left');
        $this->db->order_by('a.diubah_pada', 'DESC');
        $data = $this->db->get()->result();

        $this->response($data, 200);
    }
    // -------------------------------------------------------------------------------------------------------------------
    public function buktiPembayaran_get()
    {
        $id = $this->get('id');

        if ($id === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->select('file');
        $data = $this->db->get_where('tbl_sewa', ['id' => $id])->result();

        header("Content-type: image/jpeg");

        echo base64_decode($data[0]->file);
    }
    // -------------------------------------------------------------------------------------------------------------------
    public function konfirmasiPesanan_post()
    {
        $id = $this->post('id');
        $status = $this->post('status');

        if ($id === null || $status === null) {
            $this->response(['message' => 'Akses ditolak'], 504);
        }

        $this->db->set('status', $status);
        $this->db->where('id', $id);
        $update = $this->db->update('tbl_sewa');

        $msg = $status == 'Sukses' ? 'dikonfirmasi' : $status;

        if ($update) {
            //Kirim notifikasi ke user
            $nim = $this->post('nim');
            $this->db->select('token');
            $this->db->where('nim', $nim);
            $token = $this->db->get('tbl_user')->result()[0]->token;

            if ($token) {
                $title = 'Rusunawa UM Parepare';
                switch ($status) {
                    case 'Sukses':
                        $text = "Pembayaran anda untuk ID Pemesanan {$id} telah dikonfirmasi";
                        break;
                    case 'Ditolak':
                        $text = "Maaf, Pembayaran anda untuk ID Pemesanan {$id} ditolak";
                        break;
                }

                $this->Model->sendPushNotification(['title' => $title, 'text' => $text, 'token' => $token]);
            }

            $this->response(['error' => false, 'message' => "Pembayaran berhasil {$msg}"], 200);
        }
        $this->response(['error' => false, 'message' => "Pembayaran gagal {$msg}"], 200);
    }
    // -------------------------------------------------------------------------------------------------------------------    
}
