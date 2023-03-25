<?php

namespace App\Mail;

use App\Models\Commande;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Queue\SerializesModels;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewCommandeMail extends Mailable
{
    use Queueable, SerializesModels;
    private $nomClient;
    private $nomResto;
    private $numeroCommande;
    private $date;
    private $heure;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nomClient, $nomResto, $numeroCommande, $date, $heure)
    {
        $this->nomClient = $nomClient;
        $this->nomResto = $nomResto;
        $this->numeroCommande = $numeroCommande;
        $this->date = $date;
        $this->heure = $heure;
    }

    /**
     * Get the message envelope.
     *
     * @return \Illuminate\Mail\Mailables\Envelope
     */
    public function envelope()
    {
        return new Envelope(
            subject: 'Confirmation de commande',
        );
    }

    /**
     * Get the message content definition.
     *
     * @return \Illuminate\Mail\Mailables\Content
     */
    public function content()
    {
        return new Content(
            markdown: 'mail.send-new-commande-mail',
            with: [
                'nomClient' => $this->nomClient,
                'nomResto' => $this->nomResto,
                'numeroCommande' => $this->numeroCommande,
                'date' => $this->date,
                'heure' => $this->heure
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array
     */
    public function attachments()
    {
        return [];
    }
}
