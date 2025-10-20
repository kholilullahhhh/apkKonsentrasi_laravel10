<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ActivateAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;

    public function __construct(User $user)
    {
        $this->user = $user;
        // token sederhana (bisa diganti token unik dari tabel khusus verifikasi)
        $this->token = base64_encode($user->email);
    }

    public function build()
    {
        $url = url('/activate-account/' . $this->token);

        return $this->subject('Aktivasi Akun Anda')
            ->view('emails.activate-account', [
                'user' => $this->user,
                'url' => $url
            ]);
    }
}
