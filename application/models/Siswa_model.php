<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Siswa_model extends CI_Model {

    private $table = 'data_siswa';
    public $id = 'id';

    // Ini Untuk Login

	function checkUser($username){
		$query = $this->db->where(['username' => $username, 'status' => '0']);
		$query = $this->db->from($this->table);
		$query = $this->db->get();
			if($query->num_rows() != 0) return true;
			else return false;
	}
	
	function cekStatusPilih()
	{
	    $query = $this->db->where(['status' => '0', 'username' => $this->session->userdata('user')]);
		$query = $this->db->from($this->table);
		$result = $this->db->get();
		return $result->num_rows();
	}

	function loginUser($username, $password){
		$query = $this->db->where(['username' => $username]);
		$query = $this->db->from($this->table);
		$query = $this->db->get()->row();

		//Verify Password 
			if(password_verify($password, $query->password) == true) return true;
			else return false;
	}

	function dataUser(){
		$query = $this->db->where(['username' => $this->session->userdata('user')]);
		$query = $this->db->from($this->table);
		$query = $this->db->get();

		return $query;
	}

	function pilih($session, $id_calon){

		$id_user = $this->db->get_where($this->table, ['username' => $session])->row('id');
		$data_suara = $this->db->get_where('calon', ['id' => $id_calon])->row('suara');

		$total_suara = $data_suara + 1;
		$query = $this->db->update($this->table, ['status' => '1'], ['id' => $id_user]);
		$query = $this->db->update('calon', ['suara' => $total_suara], ['id' => $id_calon]);
		
		if ($query == true) {
			return true;
		} else {
			return false;
		}
	}

	// Ini Untuk Crud

	function JumlahPemilih(){
		$result = $this->db->get($this->table);
		return $result->num_rows();
	}

	// Sudah Memilih
	function sudahMemilih(){
		$query = $this->db->where(['status' => '1']);
		$query = $this->db->from($this->table);
		$result = $this->db->get();
		return $result->num_rows();
	}

	// Belum Memilih
	function belumMemilih(){
		$query = $this->db->where(['status' => '0']);
		$query = $this->db->from($this->table);
		$result = $this->db->get();
		return $result->num_rows();
	}

	function dataTampil(){
		$result = $this->db->get($this->table);

		return $result;
	}

// Tambah
	function dataTambahExcel($a, $b, $c, $d, $e){
		$hash = password_hash($b, PASSWORD_DEFAULT);
		$data = [
				'username' => $a,
				'password' => $hash,
				'nama' => $c,
				'jns_kelamin' => $d,
				'kelas' => $e,
				'status' => '0'
			];
		return $this->db->insert($this->table, $data);
	}

	function dataTambahManual($a, $b, $c, $d, $e){
		$hash = password_hash($b, PASSWORD_DEFAULT);
		$data = [
				'username' => $a,
				'password' => $hash,
				'nama' => $c,
				'jns_kelamin' => $d,
				'kelas' => $e,
				'status' => '0'
			];
		return $this->db->insert($this->table, $data);
	}

// Hapus
	function dataHapus(){
		return $this->db->truncate($this->table);
	}
}