<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;

use Firefly\FilamentBlog\Facades\SEOMeta;
use Firefly\FilamentBlog\Models\NewsLetter;
use Firefly\FilamentBlog\Models\Post;
use Firefly\FilamentBlog\Models\ShareSnippet;

class HomeController extends Controller
{
    //
    public function commingsoon(){
        return view('home.commingsoon');
    }
   public function index(){
    SEOMeta::setTitle('All posts | '.config('app.name')) ;

    $posts = Post::query()->with(['categories', 'user'])
        ->published()
        ->paginate(20);
    return view('home.index', [
        'posts' => $posts,
    ]);
   }

    public function about(){
        return view('home.about');
    }

    public function contact(){
        return view('home.contact');
    }

    public function contactform(Request $request){
        $request->validate([
            'firstname' => 'required',
            'lastname' => 'required',
            'email' => 'required|email',
            'phonenumber' => 'required',
            'message' => 'required'
        ]);

        $details = [
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phonenumber' => $request->phonenumber,
            'email' => $request->email,
            'message' => $request->message,
        ];

        // Mail::to(env('ADMIN_EMAIL'))->send(new ContactMail($details));

        return back()->with('success', 'Your message has been sent!');
    }

    public function assetmanagement(){
        return view('home.assetmanagement');
    }
    public function principalconsulting(){
        return view('home.principalconsulting');
    }
    public function greenrealty(){
        return view('home.greenrealty');
    }

    public function article(){
        return view('home.article');
    }

    public function whistle(){
        return view('home.whistle');
    }

    public function legal(){
        return view('home.legal');
    }

    public function privacy(){
        return view('home.privacy');
    }

    public function welcome(){
        return view('home.welcome');
    }

    public function inflation(){
        return view('home.inflation');
    }

    public function shifting(){
        return view('home.shifting');
    }

    public function februaryreport(){
        return view('home.februaryreport');
    }



}
