<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class CarController extends Controller
{
    // hiển thị danh sách xe
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $query = Car::with('category')->orderBy('created_at', 'desc');
        
        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }
        
        $cars = $query->paginate(10)->appends(['search' => $search]); 
        $categories = \App\Models\Category::all();
        
        return view('admin.car', compact('cars', 'categories', 'search'));
    }
    
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:available,rented,maintenance'
        ]);

        $car = Car::findOrFail($id);
        $car->status = $request->status;
        $car->save();

        return back()->with('success', 'Đã cập nhật trạng thái xe thành công!');
    }

    // hiển thị form thêm xe
    public function create()
    {
        $categories = Category::all();
        return view('admin.add-car', compact('categories'));    
    }

    // add
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'seats' => 'required|string',
            'transmission' => 'required|string',
            'fuel_type' => 'required|string',
            'price_per_day' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $data['status'] = 'available';

        Car::create($data);

        return redirect()->route('admin.cars.index')->with('success', 'Đã thêm xe mới thành công!');    
    }

    // edit
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-car', compact('car', 'categories'));    }

    
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'seats' => 'required|string',
            'transmission' => 'required|string', 
            'fuel_type' => 'required|string',
            'price_per_day' => 'required|numeric',
            'status' => 'required|in:available,rented,maintenance',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($car->image) Storage::disk('public')->delete($car->image);
            $data['image'] = $request->file('image')->store('cars', 'public');
        }

        $car->update($data);

        return redirect()->route('admin.cars.index')->with('success', 'Đã cập nhật thông tin xe!');
    }

    // del
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        if ($car->image) {
            Storage::disk('public')->delete($car->image);
        }
        $car->delete();

        return back()->with('success', 'Đã xóa xe khỏi hệ thống!');
    }
}