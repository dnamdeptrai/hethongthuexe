<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $messages = Contact::orderBy('created_at', 'desc')->get();
        
        $activeMessage = null;
        if ($request->has('id')) {
            $activeMessage = Contact::find($request->get('id'));
        } elseif ($messages->count() > 0) {
            $activeMessage = $messages->first();
        }
        
        return view('admin.message', compact('messages', 'activeMessage'));
    }
}