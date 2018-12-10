<?php
namespace App\buildcommerce\Mailers;

use App\Artvenue\Models\User;

class UserMailer extends Mailer
{

    public function activation($view, $user, $token, $storeName = null)
    {
        $subject = "Welcome";
        $data = [
            'fullname'       => $user->firstname.' '.$user->lastname,
            'username'       => $user->username,
            'token' => $token,
            'storeName' => $storeName
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }

    public function activationQR($view, $user, $token, $storeName = null)
    {
        $subject = "Welcome";
        $data = [
            'fullname'       => $user->fullname,
            'username'       => $user->username,
            'code' => $token,
            'storeName' => $storeName
        ];

        return $this->sendTo($user, $subject, $view, $data);
    }


    public function followMail(User $to, User $from)
    {
        if ( ! $to->email_follow) {
            return;
        }

        $subject = "New Follower";
        $view = 'emails.usermailer.follow';
        $data = [
            'senderFullname'    => ucfirst($from->fullname),
            'senderProfileLink' => route('user', ['username' => $from->username])
        ];

        return $this->sendTo($to, $subject, $view, $data);
    }
}