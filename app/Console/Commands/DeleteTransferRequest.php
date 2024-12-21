<?php

namespace App\Console\Commands;

use App\Models\Transfer\TransfersModel;
use Carbon\Carbon;
use Exception;
use Illuminate\Console\Command;

class DeleteTransferRequest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:delete-transfer-request';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete Transfer Request after 15 if no action execute';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $date = Carbon::now()->subDay(15);
            $delete_records = TransfersModel::where([
                ['created_at', '<=', $date],
                ['request_status',4]
            ])->delete();
        } catch (Exception $err) {
            print_r($err->getMessage());
        }
    }
}
