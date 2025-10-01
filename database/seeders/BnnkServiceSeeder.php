<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\BnnkService;

class BnnkServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name' => 'Rehabilitasi Medis',
                'description' => 'Layanan rehabilitasi medis untuk pecandu narkoba dengan program rawat inap dan rawat jalan terapi substitusi',
                'contact_info' => '(031) 8433-456 / WA: 0811-234-567',
                'schedule' => 'Senin-Jumat: 08:00-16:00 WIB, Sabtu: 08:00-12:00 WIB',
                'requirements' => 'KTP, KK, Surat rujukan dokter/puskesmas, Hasil tes urine, Surat pernyataan kesediaan keluarga',
                'keywords' => ['rehabilitasi', 'rehab', 'rawat', 'pecandu', 'ketergantungan', 'medis', 'terapi'],
                'icon' => '🏥',
                'order_priority' => 5,
                'is_active' => true
            ],
            [
                'name' => 'Konseling & Terapi',
                'description' => 'Layanan konseling psikologi untuk korban penyalahgunaan narkoba, keluarga, terapi individual dan kelompok',
                'contact_info' => '(031) 8433-457 / WA: 0811-234-568',
                'schedule' => 'Senin-Jumat: 08:00-15:00 WIB (dengan perjanjian)',
                'requirements' => 'KTP, Surat permohonan konseling, Mengisi formulir asesmen awal',
                'keywords' => ['konseling', 'terapi', 'psikolog', 'curhat', 'bantuan', 'psychological'],
                'icon' => '🗣️',
                'order_priority' => 4,
                'is_active' => true
            ],
            [
                'name' => 'Tes Urine Narkoba',
                'description' => 'Layanan pemeriksaan urine untuk deteksi penggunaan narkoba (individu/instansi) dengan metode rapid test dan konfirmasi lab',
                'contact_info' => '(031) 8433-458 / WA: 0811-234-569',
                'schedule' => 'Senin-Jumat: 08:00-14:00 WIB',
                'requirements' => 'KTP, Surat permohonan dari instansi/pribadi, Biaya Rp 75.000 (individu), Rp 65.000 (instansi)',
                'keywords' => ['tes urine', 'drug test', 'cek narkoba', 'screening', 'pemeriksaan'],
                'icon' => '🧪',
                'order_priority' => 3,
                'is_active' => true
            ],
            [
                'name' => 'Penyuluhan & Sosialisasi P4GN',
                'description' => 'Program penyuluhan Pencegahan Pemberantasan Penyalahgunaan dan Peredaran Gelap Narkoba ke sekolah, kampus, instansi, dan masyarakat',
                'contact_info' => '(031) 8433-459 / WA: 0811-234-570',
                'schedule' => 'Senin-Jumat: 08:00-16:00 WIB (koordinasi H-7 hari kerja)',
                'requirements' => 'Surat undangan resmi, Proposal kegiatan, Konfirmasi minimal 25 peserta, Fasilitas sound system',
                'keywords' => ['penyuluhan', 'sosialisasi', 'seminar', 'p4gn', 'edukasi', 'pencegahan'],
                'icon' => '📚',
                'order_priority' => 2,
                'is_active' => true
            ],
            [
                'name' => 'Pelaporan Tindak Pidana',
                'description' => 'Melayani laporan masyarakat terkait tindak pidana narkoba dengan jaminan kerahasiaan identitas pelapor',
                'contact_info' => 'Hotline: 184 / SMS: 0811-888-184 / WA: 0811-234-571',
                'schedule' => '24 Jam (Hotline), Senin-Jumat: 08:00-16:00 WIB (datang langsung)',
                'requirements' => 'Identitas pelapor (bisa anonim), Informasi detail lokasi dan waktu kejadian, Bukti jika ada',
                'keywords' => ['lapor', 'aduan', 'report', 'tindak pidana', 'narkoba', 'dealer', 'bandar'],
                'icon' => '📢',
                'order_priority' => 1,
                'is_active' => true
            ],
            [
                'name' => 'Asesmen & Diagnostik',
                'description' => 'Layanan asesmen komprehensif untuk menentukan tingkat keparahan penggunaan narkoba dan rencana treatment',
                'contact_info' => '(031) 8433-460 / WA: 0811-234-572',
                'schedule' => 'Senin, Rabu, Jumat: 08:00-12:00 WIB (dengan appointment)',
                'requirements' => 'KTP, Surat rujukan (jika ada), Hasil tes urine, Surat persetujuan asesmen',
                'keywords' => ['asesmen', 'assessment', 'diagnostik', 'evaluasi', 'pemeriksaan'],
                'icon' => '📋',
                'order_priority' => 0,
                'is_active' => true
            ]
        ];

        foreach ($services as $service) {
            BnnkService::updateOrCreate(
                ['name' => $service['name']],
                $service
            );
        }
    }
}
