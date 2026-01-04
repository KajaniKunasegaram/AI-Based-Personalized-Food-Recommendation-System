<?php

namespace App\Http\Controllers;
use App\Models\BusinessHoursModel;

use Illuminate\Http\Request;

class BusinessHoursController
{
     public function index()
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $shiftsData = [];

        foreach ($days as $day) {
            $shiftsData[$day] = BusinessHoursModel::where('day_of_week', $day)->get();
        }
       

       return view('admin.business-hours',compact('days','shiftsData'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'day_of_week' => 'required|string',
            'service_types' => 'required|array',
            'open_time' => 'required',
            'close_time' => 'required',
            'is_open' => 'required|boolean',
        ]);

        $createdShifts = [];

        foreach ($request->service_types as $serviceType) {
            $shift = BusinessHoursModel::create([
                'day_of_week' => strtolower($request->day_of_week),
                'service_type' => $serviceType,
                'open_time' => $request->open_time,
                'close_time' => $request->close_time,
                'is_open' => $request->is_open,
            ]);

            $createdShifts[] = $shift;
        }

        return response()->json([
            'success' => true,
            'message' => 'Shift(s) created successfully',
            'shifts' => $createdShifts
        ]);
    }

    public function update(Request $request, BusinessHoursModel $shift)
    {
        $request->validate([
            'open_time' => 'required_if:is_open,1',
            'close_time' => 'required_if:is_open,1',
            'is_open' => 'required|boolean',
        ]);

        $shift->update([
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'is_open' => $request->is_open,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Shift updated successfully',
            'shift' => $shift
        ]);
    }

    public function destroy(BusinessHoursModel $shift)
    {
        $shift->delete();

        return response()->json([
            'success' => true,
            'message' => 'Shift deleted successfully'
        ]);
    }

    public function ViewData()
    {
        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'];
        $shiftsData = [];

        foreach ($days as $day) {
            $shiftsData[$day] = BusinessHours::where('day_of_week', $day)->get();
        }

         $reviews = Review::where('publish_online', 1)->get();

        // Calculate average rating and total count
        $averageRating = $reviews->avg('stars');
        $totalReviews = $reviews->count();
        
        return view('client.orders', compact('days', 'shiftsData', 'averageRating', 'totalReviews'));

    //   return view('ClientFolder.Contact',compact('days','shiftsData'));
    }
}