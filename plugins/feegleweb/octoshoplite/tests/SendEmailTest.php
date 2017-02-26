<?php namespace Acme\Blog\Tests\Models;

use Illuminate\Support\Facades\Mail;

class SendEmailTest extends PluginTestCase
{
    use PluginTestCase;

    public function testSendEmailToAdmin()
    {

        $vars = ['name' => 'Joe', 'user' => 'Mary'];

        Mail::send('feegleweb.octoshoplite::mail.message', $vars, function($message) {

            $message->to('nguyen.nguyen@seldatinc.com', 'Admin Person');
            $message->subject('This is a reminder');

        });
    }

}