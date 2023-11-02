<?php

namespace App\Models;

use CodeIgniter\Model;

class JabatanModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'jabatan';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['direktorate_id','divisi_id','departemen_id','section_head_id','kode_jabatan','nama_jabatan','hirarki'];

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

    // Relation
    public function getWithHierarchy($hierarchy){
        return $this->where(['hirarki' => $hierarchy]);
    }
    public function getWithCode($code){
        return $this->relationDirector()->where(['jabatan.kode_jabatan' => $code]);
    }
    public function getWithId($id){
        return $this->relationDirector()->where(['jabatan.id'=>$id]);
    }
    public function relationDirector(){
        return $this->join('direktorate','direktorate.id = jabatan.direktorate_id')
                    ->join('karyawan','karyawan.jabatan_id = jabatan.id');
    }
    public function relation($division,$departement,$section){
        $query = $this;
        if($division!=null){
            $query->join('divisi','divisi.id = jabatan.divisi_id');
        }
        if($departement!=null){
            $query->join('departemen','departemen.id = jabatan.departemen_id');
        }
        if($section!=null){
            $query->join('section_head','section_head.id = jabatan.section_head_id');
        }
        return $query;
    }
    public function changeDataWithDirector(){
        // ubah direktor
        
        // ubah jabatan
        // ubah karyawan
    }
}
