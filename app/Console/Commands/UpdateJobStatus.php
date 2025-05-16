<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PostKerja;

class UpdateJobStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'job:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update job status to inactive if the deadline has passed';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        // Cari semua pekerjaan dengan deadline yang telah lewat dan masih aktif
        $jobs = PostKerja::where('status', 'active')
            ->whereNotNull('deadline')
            ->where('deadline', '<', now())
            ->get();

        foreach ($jobs as $job) {
            $job->status = 'inactive';
            $job->save();

            $this->info("Job ID {$job->id} status updated to inactive.");
        }
    }
}
