<?php

namespace App\Models;

use CodeIgniter\Model;

class KaryawanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'karyawan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['jabatan_id','nik','nama'];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function queryJabatan(){
        return $this->table('karyawan')->join('jabatan','jabatan.id = karyawan.jabatan_id');
    }
    public function queryWhere($query,$array){
        return $query->where($array)->get();
    }
    
    // relation
    public function getAllDirector(){
         $is_director = [
            'jabatan.direktorate_id !=' => null,
            'jabatan.divisi_id' => null,
        ];
         $query = $this->queryJabatan()->join('direktorate','direktorate.id = jabatan.direktorate_id');
        return $this->queryWhere($query,$is_director);
    }
    public function getAllDivision(){
        $is_division_head = [
            'jabatan.direktorate_id !=' => null,
            'jabatan.divisi_id !=' => null,
            'jabatan.departemen_id' => null
        ];
        $query = $this->queryJabatan()->join('divisi','divisi.id = jabatan.divisi_id')->join('direktorate','direktorate.id = jabatan.direktorate_id');
        return $this->queryWhere($query,$is_division_head);
    }
    public function getAllDepartement(){
        $is_departement_head = [
            'jabatan.departemen_id != ' => null,
            'jabatan.section_head_id' => null,
        ];
        $query = $this->queryJabatan()
                    ->join('departemen','departemen.id = jabatan.departemen_id')
                    ->join('divisi','divisi.id = jabatan.divisi_id')
                    ->join('direktorate','direktorate.id = jabatan.direktorate_id');
        return $this->queryWhere($query,$is_departement_head);
    }
    public function getAllSection(){
        $is_section_head =[
            'jabatan.section_head_id !=' => null,
            'section_head.kode_staff' => null
        ];
        $query = $this->queryJabatan()
                    ->join('section_head','section_head.id = jabatan.section_head_id')
                    ->join('departemen','departemen.id = jabatan.departemen_id')
                    ->join('divisi','divisi.id = jabatan.divisi_id')
                    ->join('direktorate','direktorate.id = jabatan.direktorate_id');
        return $this->queryWhere($query,$is_section_head);
    }
    public function getAllStaff(){
        $is_staff = [
            'jabatan.section_head_id !=' => null,
            'section_head.kode_staff !=' => null
        ];
        $query = $this->queryJabatan()
                    ->join('section_head','section_head.id = jabatan.section_head_id')
                    ->join('departemen','departemen.id = jabatan.departemen_id')
                    ->join('divisi','divisi.id = jabatan.divisi_id')
                    ->join('direktorate','direktorate.id = jabatan.direktorate_id');
        return $this->queryWhere($query,$is_staff);
    }
    public function countAll(){
        $this->getAllDivision()->countAllResults();
    }
    public function allEmployee(){
        $query = $this->queryJabatan()
                    ->join('section_head','section_head.id = jabatan.section_head_id')
                    ->join('departemen','departemen.id = jabatan.departemen_id')
                    ->join('divisi','divisi.id = jabatan.divisi_id')
                    ->join('direktorate','direktorate.id = jabatan.direktorate_id')->get();
        return $query->getResultArray();
    }
}
