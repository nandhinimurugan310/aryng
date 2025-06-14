<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class RoadmapMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filename;

    public function __construct($filename)
    {
        $this->filename = $filename;
    }

    public function build()
{
    return $this->subject('Your AI Roadmap Discussion Summary')
                ->markdown('emails.roadmap')
                ->attach(storage_path("app/public/{$this->filename}"));
}

}
