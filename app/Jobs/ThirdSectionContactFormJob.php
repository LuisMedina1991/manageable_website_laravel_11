<?php

namespace App\Jobs;

use App\Mail\ThirdSectionContactFormMailable;   // Import added to make use of the created mailable
use App\Models\User;
use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Throwable;

class ThirdSectionContactFormJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $dataForEmail;

    public $tries = 3;

    public $backoff = 5;

    private $adminUser;

    /**
     * Create a new job instance.
     */
    public function __construct($validatedContactFormDataFromController)
    {
        $this->dataForEmail = $validatedContactFormDataFromController;
        $this->adminUser = User::firstWhere('is_admin', 1);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::to($this->adminUser->email)->send(new ThirdSectionContactFormMailable($this->dataForEmail));
    }

    public function failed(?Throwable $exception)
    {
        // here we are indicating that if the job fails, simply send it again
        Mail::to($this->adminUser->email)->send(new ThirdSectionContactFormMailable($this->dataForEmail));
    }
}
