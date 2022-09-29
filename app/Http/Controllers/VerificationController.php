<?php

namespace App\Http\Controllers;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\VerifiesEmails;


class VerificationController extends Controller
{
    /**
     * Where to redirect users after verification.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    public function _construct ( )
    {
        $this->middleware('auth:api')->only('resend');
        $this->middleware( 'signed')->only( 'verify');
        $this->middleware( 'throttle:6,1')->only( 'verify','resend','sendToVerify');
    }


    public function resend(Request $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return response(['message' => 'Already verified']);
        }
        $request->user()->sendEmailVerificationNotification();

        if($request->wantsJson()) {
            return response(['message'=>'Email sent']);
        }
        return back()->with('resent',true);
    }

    public function verify(Request $request) {
        auth()->loginUsingId($request->route('id'));
        if($request->route('id') != $request->user()->getKey()) {
            throw new AuthorizationException;
        }

        if($request->user()->hasVerfiedEmail()) {
            return response(['message'=>'Already verified']);
        }

        if($request->user()->markEmailAsVerified()) {
            event(new Verified($request->user()));
        }
        return response(['message'=>'Successfully verified']);
    }

}
