<?php

namespace App\Http\Controllers;

use App\Models\Hardware;
use App\Models\ProdImage;
use Illuminate\Http\Request;

class HardwareController extends Controller
{
    /**
     * Normalize image path
     */
    private function normalizePath(string $path): string
    {
        return preg_replace('#^images/products/#', '', $path);
    }

    /* =========================
        INDEX (SEARCH + PAGINATION FIXED)
    ========================= */
 public function index(Request $request)
{
    $searching = false;
    $isFound = true;

    $query = Hardware::query();

    if ($request->filled('search')) {
        $searching = true;

        $query->where(function ($q) use ($request) {
            $q->where('name', 'LIKE', '%' . $request->search . '%')
              ->orWhere('category', 'LIKE', '%' . $request->search . '%')
              ->orWhere('header', 'LIKE', '%' . $request->search . '%');
        });
    }

    $hardwares = $query->orderBy('created_at', 'desc')
                       ->paginate(9)
                       ->withQueryString();

    if ($searching && $hardwares->isEmpty()) {
        $isFound = false;
    }

    return view('admin.product.hardware.index', compact(
        'searching',
        'isFound',
        'hardwares'
    ));
}
    /* =========================
        SITE INDEX
    ========================= */
    public function siteIndex()
    {
        $hardwares  = Hardware::paginate(9);
        $categories = Hardware::select('category')->distinct()->pluck('category')->toArray();

        return view('display.hardware.index', compact('hardwares', 'categories'));
    }

    /* =========================
        STORE
    ========================= */
    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $hardware = new Hardware;
        $hardware->prod_category = 'hardware';
        $hardware->name      = $request->input('name');
        $hardware->header    = $request->input('header') ?? '';
        $hardware->desc      = $request->input('desc') ?? '';
        $hardware->price     = $request->input('price');
        $hardware->datasheet = $request->input('datasheet') ?? '';
        $hardware->category  = $request->input('category') ?? '';
        $hardware->save();

        if ($request->hasFile('imgs')) {
            foreach ($request->file('imgs') as $img) {
                $imgName = time() . rand(1000, 9999) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('images/products'), $imgName);

                ProdImage::create([
                    'prod_id'       => $hardware->id,
                    'prod_category' => 'hardware',
                    'path'          => $this->normalizePath($imgName),
                ]);
            }
        }

        return redirect()->route('hardwares.index');
    }

    /* =========================
        SHOW
    ========================= */
    public function show(Hardware $hardware)
    {
        $content = $hardware->prod_images()->get();

        return view('admin.product.hardware.show', compact('hardware', 'content'));
    }

    public function siteShow(Hardware $hardware)
    {
        $content = $hardware->prod_images()->get();

        return view('display.hardware.show', compact('hardware', 'content'));
    }

    /* =========================
        EDIT
    ========================= */
    public function edit(Hardware $hardware)
    {
        $content = $hardware->prod_images()->get();

        return view('admin.product.hardware.edit', compact('hardware', 'content'));
    }

    /* =========================
        UPDATE
    ========================= */
    public function update(Request $request, Hardware $hardware)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'price' => 'required|numeric',
        ]);

        $hardware->name      = $request->input('name');
        $hardware->header    = $request->input('header') ?: $hardware->header;
        $hardware->desc      = $request->input('desc') ?: $hardware->desc;
        $hardware->datasheet = $request->input('datasheet') ?: $hardware->datasheet;
        $hardware->category  = $request->input('category') ?: $hardware->category;
        $hardware->price     = $request->input('price');
        $hardware->save();

        if ($request->hasFile('imgs')) {
            foreach ($request->file('imgs') as $img) {
                $imgName = time() . rand(1000, 9999) . '.' . $img->getClientOriginalExtension();
                $img->move(public_path('images/products'), $imgName);

                ProdImage::create([
                    'prod_id'       => $hardware->id,
                    'prod_category' => 'hardware',
                    'path'          => $this->normalizePath($imgName),
                ]);
            }
        }

        return redirect()->route('hardwares.index');
    }

    /* =========================
        DELETE HARDWARE
    ========================= */
    public function destroy(Hardware $hardware)
    {
        foreach ($hardware->prod_images()->get() as $img) {
            $cleanPath = $this->normalizePath($img->path);
            $path = public_path('images/products/' . $cleanPath);

            if (file_exists($path)) {
                unlink($path);
            }

            $img->delete();
        }

        $hardware->delete();

        return redirect()->route('hardwares.index');
    }

    /* =========================
        DELETE IMAGE
    ========================= */
    public function deleteImg(Hardware $hardware, ProdImage $img)
    {
        $cleanPath = $this->normalizePath($img->path);
        $path = public_path('images/products/' . $cleanPath);

        if (file_exists($path)) {
            unlink($path);
        }

        $img->delete();

        return redirect()->route('hardwares.edit', $hardware);
    }
}