<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Str;
class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banner=Banner::orderBy('id','DESC')->paginate(10);
        return view('backend.banner.index')->with('banners',$banner);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.banner.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'string|required|max:50',
            'description' => 'string|nullable',
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|in:active,inactive',
        ]);
    
        $data = $request->all();
    
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            
            $uploadDirectory = public_path('uploads');
            if (!file_exists($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
    
            $photoPath = $photo->move($uploadDirectory, $photo->getClientOriginalName());
            
            $data['photo'] = 'uploads/' . $photo->getClientOriginalName();
        }
    
        $slug = Str::slug($request->title);
        $count = Banner::where('slug', $slug)->count();
        if ($count > 0) {
            $slug = $slug . '-' . date('ymdis') . '-' . rand(0, 999);
        }
        $data['slug'] = $slug;
    
        $status = Banner::create($data);
    
        if ($status) {
            request()->session()->flash('success', 'Banner successfully added');
        } else {
            request()->session()->flash('error', 'Error occurred while adding banner');
        }
    
        return redirect()->route('banner.index');
    }
    


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $banner=Banner::findOrFail($id);
        return view('backend.banner.edit')->with('banner',$banner);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $banner = Banner::findOrFail($id);

    $this->validate($request, [
        'title' => 'string|required|max:50',
        'description' => 'string|nullable',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'status' => 'required|in:active,inactive',
    ]);

    $data = $request->all();

    if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
        $photo = $request->file('photo');

        // Define upload directory
        $uploadDirectory = public_path('uploads');
        if (!file_exists($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        // Delete the old image if exists
        if ($banner->photo && file_exists(public_path($banner->photo))) {
            unlink(public_path($banner->photo));
        }

        // Store the new image
        $photoPath = $photo->move($uploadDirectory, $photo->getClientOriginalName());
        $data['photo'] = 'uploads/' . $photo->getClientOriginalName();
    }

    $status = $banner->fill($data)->save();

    if ($status) {
        request()->session()->flash('success', 'Banner successfully updated');
    } else {
        request()->session()->flash('error', 'Error occurred while updating banner');
    }

    return redirect()->route('banner.index');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $banner=Banner::findOrFail($id);
        $status=$banner->delete();
        if($status){
            request()->session()->flash('success','Banner successfully deleted');
        }
        else{
            request()->session()->flash('error','Error occurred while deleting banner');
        }
        return redirect()->route('banner.index');
    }
}