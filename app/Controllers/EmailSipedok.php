<?php

namespace App\Controllers;

class EmailSipedok extends BaseController
{
    public function test()
    {
        $email = \Config\Services::email();

        $email->setFrom(
            env('email.fromEmail'),
            env('email.fromName')
        );

        $email->setTo('EMAIL_TUJUAN_PENGUJIAN');

        $email->setSubject('Tes Email SIPEDOK');

        $email->setMessage('
            <h3>Pengujian Email SIPEDOK</h3>
            <p>Email berhasil dikirim melalui sistem SIPEDOK.</p>
        ');

        if ($email->send()) {
            return 'Email berhasil dikirim!';
        }

        return $email->printDebugger(['headers', 'subject']);
    }
}