<?php

namespace App\Console\Commands;

use App\Models\Url;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class MailReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:mail-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $details = [
            'title' => 'link expiration reminder',
        ];
        $urls = Url::where("valid_till", ">=", Carbon::now()->add(3, 'day')->toDateTimeString())->with("user")->get();
        foreach ($urls as $url) {
            $details["body"] = trans("app.link_will_expire", ["link" => $url->url]);
            Mail::to($url->user->email)->queue(new \App\Mail\ReminderMail($details));
        }
    }
}
