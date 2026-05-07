<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Software;
use App\Models\ProdImage;

class SoftwareController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        if ($search) {
            $softwares = Software::where("name", "like", "%$search%")->paginate(8);
            $searching = true;
            $isFound   = $softwares->count() > 0;
        } else {
            $softwares = Software::paginate(8);
            $searching = false;
            $isFound   = false;
        }

        return view('admin.product.software.index', compact('softwares', 'searching', 'isFound'));
    }

    public function siteIndex()
    {
        $softwares = Software::paginate(8);
        return view('display.software.index', compact('softwares'));
    }

    public function siteShow(Software $software)
    {
        $content = $software->prod_images;
        return view('display.software.show', compact('software', 'content'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required',
            'header'   => 'required',
            'desc'     => 'required',
            'payment'  => 'required', // FIX: كان ناقص
            'price'    => 'required|numeric',
            'category' => 'required',
            'imgs.*'   => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $software = Software::create([
            'name'     => $request->name,
            'header'   => $request->header,
            'desc'     => $request->desc,
            'payment'  => $request->payment, // FIX: كان ناقص
            'price'    => $request->price,
            'category' => $request->category,
        ]);

        if ($request->hasFile('imgs')) {
            foreach ($request->file('imgs') as $img) {
                $name = time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('images/products'), $name);

                ProdImage::create([
                    'prod_id'      => $software->id,
                    'prod_category' => 'software',
                    'path'         => $name
                ]);
            }
        }

        return back()->with('success', 'Added successfully');
    }

    public function edit(Software $software)
    {
        $content = $software->prod_images;
        return view('admin.product.software.edit', compact('software', 'content'));
    }

    public function update(Request $request, Software $software)
    {
        $request->validate([
            'name'     => 'required',
            'header'   => 'required',
            'desc'     => 'required',
            'payment'  => 'required',
            'price'    => 'required|numeric',
            'category' => 'required',
            'imgs.*'   => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $software->update([
            'name'     => $request->name,
            'header'   => $request->header,
            'desc'     => $request->desc,
            'payment'  => $request->payment,
            'price'    => $request->price,
            'category' => $request->category,
        ]);

        if ($request->hasFile('imgs')) {
            foreach ($request->file('imgs') as $img) {
                $name = time() . '_' . $img->getClientOriginalName();
                $img->move(public_path('images/products'), $name);

                ProdImage::create([
                    'prod_id'      => $software->id,
                    'prod_category' => 'software',
                    'path'         => $name
                ]);
            }
        }

        return back()->with('success', 'Updated successfully');
    }

    public function destroy(Software $software)
    {
        foreach ($software->prod_images as $img) {
            $path = public_path('images/products/' . $img->path);
            if (file_exists($path)) {
                unlink($path);
            }
            $img->delete();
        }

        $software->delete();
        return redirect()->route('softwares.index')->with('success', 'Deleted successfully');
    }

    public function deleteImg(Software $software, ProdImage $img)
    {
        if ($img->prod_id != $software->id || $img->prod_category != 'software') {
            abort(403);
        }

        $path = public_path('images/products/' . $img->path);
        if (file_exists($path)) {
            unlink($path);
        }

        $img->delete();
        return back()->with('success', 'Image deleted');
    }
}