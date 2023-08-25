<?php

namespace App\Console\Commands;

use App\Models\Backup;
use Carbon\Carbon;
use Illuminate\Console\Command;

class BackupDatabase extends Command
{
    protected $signature = 'backup';


    protected $description = 'Command description';

    public function __construct()
    {
        parent::__construct();
    }
    public function handle()
    {
        $filename = "backup.gz";

        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . public_path() . "/backup/" . $filename;

        $returnVar = NULL;
        $output  = NULL;

        exec($command, $output, $returnVar);
        $this->info('Databasee backup completed filename = ' . $filename);
        $backup = Backup::where('filename', $filename)->first();
        if ($backup) {

            $backup->update([
                'filename' => $filename
            ]);
        } else {
            Backup::create([
                'filename' => $filename
            ]);
        }
        $this->info('Database backup berhasil di simpan ke database Backup dengan nama = ' . $filename);
    }
}
