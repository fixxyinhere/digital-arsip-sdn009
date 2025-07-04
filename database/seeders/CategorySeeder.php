<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Administrasi Umum',
                'code' => 'ADM_UMUM',
                'description' => 'Dokumen administrasi umum sekolah',
                'color' => '#3B82F6',
            ],
            [
                'name' => 'Kurikulum',
                'code' => 'KURIKULUM',
                'description' => 'Dokumen terkait kurikulum dan pembelajaran',
                'color' => '#10B981',
            ],
            [
                'name' => 'Kesiswaan',
                'code' => 'KESISWAAN',
                'description' => 'Dokumen data siswa dan kegiatan siswa',
                'color' => '#F59E0B',
            ],
            [
                'name' => 'Kepegawaian',
                'code' => 'KEPEGAWAIAN',
                'description' => 'Dokumen data pegawai dan kepegawaian',
                'color' => '#EF4444',
            ],
            [
                'name' => 'Keuangan',
                'code' => 'KEUANGAN',
                'description' => 'Dokumen keuangan dan anggaran',
                'color' => '#8B5CF6',
            ],
            [
                'name' => 'Sarana Prasarana',
                'code' => 'SARPRAS',
                'description' => 'Dokumen sarana dan prasarana sekolah',
                'color' => '#06B6D4',
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
