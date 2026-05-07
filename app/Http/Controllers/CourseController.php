<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\ProdImage;

class CourseController extends Controller
{
public function index(Request $request)
{
    $searching = false;
    $isFound   = false;

    if ($request->search) {
        $request->flash();
        $searching = true;

        $courses = Course::with('prod_images')   // ← هنا كانت المشكلة
            ->where('name',    'LIKE', '%'.$request->search.'%')
            ->orWhere('header',   'LIKE', '%'.$request->search.'%')
            ->orWhere('category', 'LIKE', '%'.$request->search.'%')
            ->orWhere('prof',     'LIKE', '%'.$request->search.'%')
            ->paginate(4);

        $isFound = $courses->isNotEmpty();

        if (!$isFound) {
            return view('admin.product.course.index',
                compact('searching', 'isFound'));
        }

        return view('admin.product.course.index',
            compact('searching', 'isFound', 'courses'));
    }

    $courses = Course::with('prod_images')->paginate(4);

    return view('admin.product.course.index',
        compact('searching', 'courses'));
}
    public function siteIndex()
    {
        $courses = Course::with('prod_images')->get();
        $categories = [];

        foreach($courses as $item){
            if(!in_array($item->category,$categories)){
                $categories[] = $item->category;
            }
        }

        return view('display.course.index',compact('courses','categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'header'   => 'required|string|max:255',
            'desc'     => 'nullable',
            'period'   => 'required|string|max:255',
            'prof'     => 'required|string|max:255',
            'price'    => 'required|numeric',
        ]);

        $course = new Course();
        $course->prod_category = 'course';
        $course->name     = $validated['name'];
        $course->category = $validated['category'];
        $course->header   = $validated['header'];
        $course->desc     = $validated['desc'] ?? '';
        $course->period   = $validated['period'];
        $course->prof     = $validated['prof'];
        $course->price    = $validated['price'];
        $course->save();

        if($request->file('imgs')){
            foreach($request->file('imgs') as $img){
                $imgName = time().rand(1,999).'.'.$img->extension();
                $img->move(public_path('images/courses'), $imgName);

                $prodImage = new ProdImage();
                $prodImage->prod_id       = $course->id;
                $prodImage->prod_category = 'course';
                $prodImage->path          = 'courses/'.$imgName; // CORRECTION: prefix courses/
                $prodImage->save();
            }
        }

        return redirect(route('courses.index'));
    }

    public function siteShow(Course $course)
    {
        $content = $course->prod_images()->get();

        $reviews = $course->reviews() // FIX: كانت Reviews() بحرف كبير، الصحيح reviews()
        ->where('is_approved', true)
        ->get();

        return view('display.course.show', compact('course','content','reviews'));
    }

    public function edit(Course $course)
    {
        $content = $course->prod_images()->get();
        return view('admin.product.course.edit', compact('course','content'));
    }

    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'header'   => 'nullable|string|max:255',
            'desc'     => 'nullable',
            'period'   => 'nullable|string|max:255',
            'prof'     => 'nullable|string|max:255',
            'price'    => 'required|numeric',
        ]);

        $course->name     = $validated['name'];
        $course->category = $validated['category'] ?? $course->category;
        $course->header   = $validated['header']   ?? $course->header;
        $course->desc     = $validated['desc']     ?? $course->desc;
        $course->period   = $validated['period']   ?? $course->period;
        $course->prof     = $validated['prof']     ?? $course->prof;
        $course->price    = $validated['price'];
        $course->save();

        if($request->hasFile('imgs')){
            foreach($request->file('imgs') as $img){
                $imgName = time().rand(1,999).'.'.$img->extension();
                $img->move(public_path('images/courses'), $imgName);

                ProdImage::create([
                    'prod_id'       => $course->id,
                    'prod_category' => 'course',
                    'path'          => 'courses/'.$imgName, // CORRECTION: prefix courses/
                ]);
            }
        }

        return redirect()->route('courses.index')->with('success', 'Updated!');
    }

    public function destroy(Course $course)
    {
        foreach($course->prod_images as $img){
            // CORRECTION: path complet depuis public/images/
            $path = public_path('images/'.$img->path);
            if(file_exists($path)){
                unlink($path);
            }
            $img->delete();
        }

        $course->delete();
        return redirect(route('courses.index'));
    }

    public function deleteImg(Course $course, ProdImage $img)
    {
        // CORRECTION: path complet depuis public/images/
        $path = public_path('images/'.$img->path);
        if(file_exists($path)){
            unlink($path);
        }

        $img->delete();
        return redirect(route('courses.edit', $course));
    }
}