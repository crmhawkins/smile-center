<?php 
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Mail\MailNewsletter;
use Illuminate\Support\Facades\Mail;
use App\Models\Newsletters\Newsletter;
use Illuminate\Support\Facades\Log;

class SendBulkQueueEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $details;
    public $timeout = 7200; // 2 hours

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $id = $this->details->id_newsletter;
        Log::info("ID: ".$id);
        $newsletter = Newsletter::where('id', $id)->update(["sent" => true]);

        $email = new MailNewsletter($this->details);
        Mail::to($this->details->to)->send($email);
    }
}

?>