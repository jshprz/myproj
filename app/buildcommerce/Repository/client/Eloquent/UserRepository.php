<?php 
namespace App\buildcommerce\Repository\client\Eloquent;

use App\buildcommerce\Mailers\UserMailer;
use App\buildcommerce\Repository\client\UserRepositoryInterface;
use App\buildcommerce\Models\User;
use App\buildcommerce\Models\Notification;
use Carbon\Carbon;
use Auth;
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(User $user, UserMailer $mailer, Notification $notification)
    {
        $this->model = $user;
        $this->mailer = $mailer;
        $this->notification = $notification;
    }

    public function registerAccount($request)
    {
        $token = sha1(str_random(11) . (time() * rand(2, 2000)));

        $this->model->firstname = $request->firstname;
        $this->model->lastname = $request->lastname;
        $this->model->email = $request->email;
        $this->model->password = bcrypt($request->password);
        $this->model->role = 2;
        $this->model->token = $token;
        $this->model->save();
        $view = 'client-side.mail.confirmation';

        $this->mailer->activation($view,$request,$token);
        return true;
    }
    public function activate($token)
    {
        $user = $this->model->where('token',$token)->first();
        if($user->token === $token)
        {
            $user->confirmed_at = Carbon::now();
            $user->confirmed = true;
            $user->token = null;
            $user->save();

            return $user;
        }
        else
        {
            return false;
        }
    }

    public function getNotifications()
    {
        $query = $this->notification->where('user_id',Auth::user()->id)->get();
        return response()->json($query);
    }

    public function unreadNotification()
    {
        $query = $this->notification->where('user_id',Auth::user()->id)->where('read',false)->count();
        return response()->json($query);
    }

    public function readNotification()
    {
        $query = $this->notification->where('user_id',Auth::user()->id)->update(['read' => true]);
        return response()->json(true);
    }
}