<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Promotion;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;


class PromotionController extends Controller
{
    public function index()
    {
        // ✅ Use pagination to match index.blade.php and reduce load on large datasets
        $promotions = Promotion::orderBy('end_date', 'desc')->paginate(10);
        return view('admin.promotions.index', compact('promotions'));
    }

    public function create()
    {
        return view('admin.promotions.create');
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:fixed,percent',
        'value' => 'required|numeric|min:0.01',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'auto_apply' => 'nullable|boolean',
        'code' => 'nullable|string|max:50|unique:promotions,code',
        'promo_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('promo_image')) {
        $image = $request->file('promo_image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = storage_path('app/public/promotions/' . $filename);

        $manager = new ImageManager(new Driver());
        $manager->read($image)->resize(800, 400)->save($path);

        $validated['promo_image'] = 'promotions/' . $filename;
    }

    // 👇 default to false if checkbox not checked
    $validated['auto_apply'] = $request->has('auto_apply');

    Promotion::create($validated);

    return redirect()->route('promotions.index')->with('success', 'Promotion added.');
}




    public function destroy(Promotion $promotion)
    {
        $promotion->delete();
        return redirect()->route('promotions.index')->with('success', 'Promotion deleted.');
    }
    public function edit(Promotion $promotion)
{
    return view('admin.promotions.edit', compact('promotion'));
}

public function update(Request $request, Promotion $promotion)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:fixed,percent',
        'value' => 'required|numeric|min:0.01',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after_or_equal:start_date',
        'auto_apply' => 'nullable|boolean',
        'code' => 'nullable|string|max:50|unique:promotions,code,' . $promotion->id,
        'promo_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('promo_image')) {
        $image = $request->file('promo_image');
        $filename = time() . '.' . $image->getClientOriginalExtension();
        $path = storage_path('app/public/promotions/' . $filename);

        $manager = new ImageManager(new Driver());
        $manager->read($image)->resize(800, 400)->save($path);

        $validated['promo_image'] = 'promotions/' . $filename;
    }

    $validated['auto_apply'] = $request->has('auto_apply');

    $promotion->update($validated);

    return redirect()->route('promotions.index')->with('success', 'Promotion updated.');
}


}
