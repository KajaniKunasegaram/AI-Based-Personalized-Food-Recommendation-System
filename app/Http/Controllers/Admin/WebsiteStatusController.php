<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WebsiteStatusModel;
class WebsiteStatusController extends Controller
{
    public function index()
    {
        $current = WebsiteStatusModel::latest()->first();
        return view('admin.website-status', compact('current'));
    }

    public function save(Request $request)
    {
        // Determine which toggle is ON
        $status = 'open'; // default

        if ($request->has('close_today'))   $status = 'closed_today';
        if ($request->has('closed_until'))  $status = 'closed_until';
        if ($request->has('closed'))        $status = 'closed';
        if ($request->has('open_as_usual')) $status = 'open';

        WebsiteStatusModel::create([
            'status'      => $status,
            'reopen_date' => $status === 'closed_until' ? $request->input('reopen-date') : null,
            'message'     => $request->input('message'),
        ]);

        return back()->with('success', 'Status updated successfully!');
    }
}
