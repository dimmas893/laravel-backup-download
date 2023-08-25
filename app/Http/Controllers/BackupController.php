<?php

namespace App\Http\Controllers;

use App\Models\Backup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class BackupController extends Controller
{
    public function backup()
    {
        Artisan::call('backup');
        $backup = Backup::latest()->first(); // Menggunakan latest() untuk mendapatkan backup terbaru
        $fileSql = public_path('backup/' . $backup->filename);

        if (file_exists($fileSql)) {
            return response()->download($fileSql, $backup->filename);
        } else {
            // Berkas tidak ditemukan, tampilkan pesan atau tangani secara sesuai
            return redirect()->back()->with('error', 'File backup tidak ditemukan.');
        }
    }
}
