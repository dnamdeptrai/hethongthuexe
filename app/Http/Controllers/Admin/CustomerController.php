<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        //role user
        $query = User::where('role', 'user')
                     ->withCount('bookings')
                     ->orderBy('created_at', 'desc');
        // tìm theo email, ten, sdt
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        $customers = $query->paginate(10)->appends(['search' => $search]);
        
        return view('admin.customer', compact('customers', 'search'));
    }
    public function show($id)
    {
        $customer = User::where('role', 'user')
                        ->with(['bookings' => function($query) {
                            $query->orderBy('created_at', 'desc');
                        }, 'bookings.car'])
                        ->findOrFail($id);

        return view('admin.customer-detail', compact('customer'));
    }
}