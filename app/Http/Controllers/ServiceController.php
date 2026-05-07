<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\ProdImage;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        if($request->search){
            $request->flash();
            $searching = true;

            $services = Service::where('name','LIKE','%'.$request->search.'%')
                        ->orWhere('header','LIKE','%'.$request->search.'%')
                        ->paginate(4);

            $isFound = $services->count() > 0;

            return view('admin.product.service.index', compact('searching','isFound','services'));
        }

        $searching = false;
        $isFound   = false;
        $services  = Service::paginate(4);

        return view('admin.product.service.index', compact('searching', 'isFound', 'services'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'header' => 'required',
            'desc' => 'required',
            'page' => 'required',
            'price' => 'required|numeric',
            'imgs.*' => 'image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $service = Service::create([
            'prod_category' => 'service',
            'name' => $validated['name'],
            'header' => $validated['header'],
            'desc' => $validated['desc'],
            'page' => $validated['page'],
            'price' => $validated['price'],
        ]);

       
        if($request->hasFile('imgs')){
            foreach($request->file('imgs') as $img){

                $name = time().'_'.$img->getClientOriginalName();
                $img->move(public_path('images/products'), $name);

                ProdImage::create([
                    'prod_id' => $service->id,
                    'prod_category' => 'service',
                    'path' => $name
                ]);
            }
        }

        return redirect()->route('services.index')->with('success','Added successfully');
    }

    public function edit(Service $service)
    {
        $content = $service->prod_images;
        return view('admin.product.service.edit', compact('service','content'));
    }

 public function update(Request $request, Service $service)
{
    $validated = $request->validate([
        'name' => 'required',
        'header' => 'required',
        'desc' => 'required',
        'page' => 'required',
        'price' => 'required|numeric',
        'imgs.*' => 'image|mimes:jpg,jpeg,png|max:2048'
    ]);

  
    $service->update([
        'name' => $validated['name'],
        'header' => $validated['header'],
        'desc' => $validated['desc'],
        'page' => $validated['page'],
        'price' => $validated['price'],
    ]);


    if($request->hasFile('imgs')){
        foreach($request->file('imgs') as $img){

            $name = time().'_'.$img->getClientOriginalName();
            $img->move(public_path('images/products'), $name);

            \App\Models\ProdImage::create([
                'prod_id' => $service->id,
                'prod_category' => 'service',
                'path' => $name
            ]);
        }
    }

    return redirect()->route('services.index')->with('success','Updated successfully');
}

public function siteShow(\App\Models\Service $service)
{
    $service->load('prod_images');

    $reviews = \App\Models\Review::where('prod_id', $service->id)
        ->where('prod_category', 'service')
        ->get();

return view('display.service.show', compact('service','reviews'));
}

    public function destroy(Service $service)
    {
        foreach($service->prod_images as $img){

            $path = public_path('images/products/'.$img->path);

            if(file_exists($path)){
                unlink($path);
            }

            $img->delete();
        }

        $service->delete();

        return redirect()->route('services.index')->with('success','Deleted successfully');
    }

    public function deleteImg(Service $service, ProdImage $img)
    {
        $path = public_path('images/products/'.$img->path);

        if(file_exists($path)){
            unlink($path);
        }

        $img->delete();

        return redirect()->route('services.edit',$service)->with('success','Image deleted');
    }
}