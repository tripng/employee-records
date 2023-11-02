<?php

namespace App\Database\Seeds;
use CodeIgniter\I18n\Time;

use CodeIgniter\Database\Seeder;

class JabatanSeeder extends Seeder
{
    public function run()
    {
        $positions = [
            'direktor A' => [
                'divisi_id' => null,
                'departemen_id' => null,
                'section_head_id' => null,
                'hirarki' => 'direktor',
                'kode_jabatan' => 'A',
            ],'divisi A' => [
                'divisi_id' => 1,
                'departemen_id' => null,
                'section_head_id' => null,
                'hirarki' => 'divisi',
                'kode_jabatan' => 'AA',
            ],'divisi B'=> [
                'divisi_id' => 2,
                'departemen_id' => null,
                'section_head_id' => null,
                'hirarki' => 'divisi',
                'kode_jabatan' => 'AB',
            ],'departemen A'=> [
                'divisi_id' => 1,
                'departemen_id' => 1,
                'section_head_id' => null,
                'hirarki' => 'departemen',
                'kode_jabatan' => 'AAA',
            ],'departemen B'=> [
                'divisi_id' => 1,
                'departemen_id' => 2,
                'section_head_id' => null,
                'hirarki' => 'departemen',
                'kode_jabatan' => 'AAB',
            ],'departemen C'=> [
                'divisi_id' => 2,
                'departemen_id' => 3,
                'section_head_id' => null,
                'hirarki' => 'departemen',
                'kode_jabatan' => 'ABC',
            ],' departemen D'=> [
                'divisi_id' => 2,
                'departemen_id' => 4,
                'section_head_id' => null,
                'hirarki' => 'departemen',
                'kode_jabatan' => 'ABD',
            ],'section head A'=> [
                'divisi_id' => 1,
                'departemen_id' => 1,
                'section_head_id' => 1,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'AAAA',
            ],'section head B'=> [
                'divisi_id' => 1,
                'departemen_id' => 1,
                'section_head_id' => 2,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'AAAB',
            ],'section head C'=> [
                'divisi_id' => 1,
                'departemen_id' => 2,
                'section_head_id' => 3,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'AABC',
            ],'section head D'=> [
                'divisi_id' => 1,
                'departemen_id' => 2,
                'section_head_id' => 4,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'AABD',
            ],'section head E'=> [
                'divisi_id' => 2,
                'departemen_id' => 3,
                'section_head_id' => 5,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'ABCE',
            ],'section head F'=> [
                'divisi_id' => 2,
                'departemen_id' => 3,
                'section_head_id' => 6,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'ABCF',
            ],'section head G'=> [
                'divisi_id' => 2,
                'departemen_id' => 4,
                'section_head_id' => 7,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'ABDG',
            ],'section head H'=> [
                'divisi_id' => 2,
                'departemen_id' => 4,
                'section_head_id' => 8,
                'hirarki' => 'bagian',
                'kode_jabatan' => 'ABDH',
            ],'staff A'=> [
                'divisi_id' => 1,
                'departemen_id' => 1,
                'section_head_id' => 9,
                'hirarki' => 'staf',
                'kode_jabatan' => 'AAAAA',
            ],'staff B'=> [
                'divisi_id' => 1,
                'departemen_id' => 1,
                'section_head_id' => 10,
                'hirarki' => 'staf',
                'kode_jabatan' => 'AAABB',
            ],'staff C'=> [
                'divisi_id' => 1,
                'departemen_id' => 2,
                'section_head_id' => 11,
                'hirarki' => 'staf',
                'kode_jabatan' => 'AABCC',
            ],'staff D'=>[
                'divisi_id' => 1,
                'departemen_id' => 2,
                'section_head_id' => 12,
                'hirarki' => 'staf',
                'kode_jabatan' => 'AABDD',
            ],'staff E'=>[
                'divisi_id' => 2,
                'departemen_id' => 3,
                'section_head_id' => 13,
                'hirarki' => 'staf',
                'kode_jabatan' => 'ABCEE',
            ],'staff F'=>[
                'divisi_id' => 2,
                'departemen_id' => 3,
                'section_head_id' => 14,
                'hirarki' => 'staf',
                'kode_jabatan' => 'ABCFF',
            ],'staff G'=>[
                'divisi_id' => 2,
                'departemen_id' => 4,
                'section_head_id' => 15,
                'hirarki' => 'staf',
                'kode_jabatan' => 'ABDGG',
            ],'staff H'=>[
                'divisi_id' => 2,
                'departemen_id' => 4,
                'section_head_id' => 16,
                'hirarki' => 'staf',
                'kode_jabatan' => 'ABDHH',
            ]
        ];
        $alphabet = range('A','Z');
        $num=0;
        foreach($positions as $position => $value){
            $jabatan = [
                'direktorate_id' => 1,
                'divisi_id' => $value['divisi_id'],
                'departemen_id' => $value['departemen_id'],
                'section_head_id' => $value['section_head_id'],
                'kode_jabatan' =>$value['kode_jabatan'],
                'hirarki' => $value['hirarki'],
                'nama_jabatan' => $position, 
                'created_at' => Time::now(),
                'updated_at' => Time::now()
            ];
            $this->db->table('jabatan')->insert($jabatan);
            $num++;
        }
    }
}