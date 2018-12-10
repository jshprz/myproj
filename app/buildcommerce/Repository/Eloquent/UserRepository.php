<?php 
namespace App\buildcommerce\Repository\Eloquent;

use App\buildcommerce\Mailers\UserMailer;
use App\buildcommerce\Repository\UserRepositoryInterface;
use App\buildcommerce\Models\StoreUsers;
use Carbon\Carbon;
use App\buildcommerce\Repository\StoreRepositoryInterface;
use Auth;
use App\buildcommerce\Models\Feedback;
use App\buildcommerce\Models\Star;
class UserRepository extends AbstractRepository implements UserRepositoryInterface
{
    public function __construct(StoreUsers $user, UserMailer $mailer, StoreRepositoryInterface $store, Feedback $feedback, Star $star)
    {
        $this->model = $user;
        $this->store = $store;
        $this->mailer = $mailer;
        $this->feedback = $feedback;
        $this->star = $star;
    }

    public function registerBuyerAccount($request)
    {
        
        $store_id = $this->store->getStoreByName($request->store_name)->id;
        $token = sha1(str_random(11) . (time() * rand(2, 2000)));
        $this->model->store_id = $store_id;
        $this->model->firstname = $request->firstname;
        $this->model->lastname = $request->lastname;
        $this->model->email = $request->email;
        $this->model->password = bcrypt($request->password);
        $this->model->role = 2;
        $this->model->token = $token;
        $this->model->save();
        $view = 'buyer-side.mail.confirmation';

        $this->mailer->activation($view,$this->model,$token,$request->store_name);
        return true;
    }
    public function activate($token)
    {
        $user = $this->model->where('token',$token)->first();
        if(isset($user->token))
        {
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
    }

    public function verifyIfAuthenticated($storeName)
    {
        $check_buyer = $this->store->getStoreByName($storeName);
        if($check_buyer->id == Auth::guard('buyer')->user()->store_id)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function createFeedback($request)
    {
        $this->feedback->buyer_id = Auth::guard('buyer')->user()->id;
        $this->feedback->product_id = $request->product_id;
        $this->feedback->message = $request->message;
        $this->feedback->title = $request->title;
        $this->feedback->save();
        return true;
    }
     public function createStar($request)
     {
        $this->star->buyer_id = Auth::guard('buyer')->user()->id;
        $this->star->product_id = $request->product_id;
        $this->star->stars = $request->star;
        $this->star->save();
        return response()->json(true);
     }
}