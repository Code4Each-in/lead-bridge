<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LeadStatusNotification extends Notification
{
    protected $lead;
    protected $type;
    protected $count;

    public function __construct($lead = null, $type = null, $count = null)
    {
        $this->lead = $lead;
        $this->type = $type;
        $this->count = $count;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $data = [];

        switch ($this->type) {

            case 'bulk_assign':
                $data = [
                    'title' => 'New Leads Assigned',
                    'messageText' => "You have been assigned {$this->count} new leads.",
                ];
                break;

            case 'to_qa':
                $data = [
                    'title' => 'Lead Assigned to QA',
                    'messageText' => 'A lead has been moved to QA.',
                ];
                break;

            case 'to_manager':
                $data = [
                    'title' => 'Lead Assigned to Manager',
                    'messageText' => 'Lead moved to Manager.',
                ];
                break;

            case 'return_ae':
                $data = [
                    'title' => 'Lead Returned to AE',
                    'messageText' => 'Lead has been returned to Account Executive.',
                ];
                break;

            case 'completed':
                $data = [
                    'title' => 'Lead Completed',
                    'messageText' => 'Lead marked as completed.',
                ];
                break;

            case 'lost':
                $data = [
                    'title' => 'Lead Lost',
                    'messageText' => 'Lead marked as lost.',
                ];
                break;

            case 'to_ae':
                $data = [
                    'title' => 'New Lead Assigned',
                    'messageText' => 'A new lead has been assigned to you.',
                ];
                break;
        }

        return (new MailMessage)
            ->subject($data['title'])
            ->view('emails.lead-status', [
                'lead' => $this->lead,
                'title' => $data['title'],
                'messageText' => $data['messageText'],
                'count' => $this->count
            ]);
    }
}
