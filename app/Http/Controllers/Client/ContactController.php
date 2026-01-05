<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\BusinessHoursModel;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;

class ContactController extends Controller
{

     public function index()
{
    $days = ['Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday'];

    $shiftsData = [];

    foreach ($days as $day) {
        $shiftsData[$day] = BusinessHoursModel::where('day_of_week', strtolower($day))->get();
    }

    return view('client.contact', compact('days','shiftsData'));
}

    public function submit(Request $request)
    {
        // Validate input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // You can either save to DB or send an email
        // Example: send email
        Mail::raw($request->message, function($mail) use ($request){
            $mail->to('kajani2017@gmail.com')
                 ->subject($request->subject)
                 ->from($request->email, $request->name);
        });

        return back()->with('success', 'Your message has been sent successfully!');
    }
}
