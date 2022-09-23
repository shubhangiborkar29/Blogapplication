<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Blog;

class BlogController extends Controller
{
    public function index(){

 return view('backend.blog.create');

}

public function store(Request $request){
    $validated = $request->validate([
        'title' => 'required',
        'description' => 'required',
        'image' => 'required',

    ]);

    $data=new Blog();
    $data->title=$request->title;
    $data->description=$request->description;
   if($request->hasFile('image'))
        {
            $file=$request->image;
            $extension=$file->getClientOriginalExtension();
            $filename=time().'.'.$extension;
            $file->move('uploads',$filename);
            $data->image=$filename;


        }
   $data->save();
   return redirect()->route('admin.blog.table')->with('msg','Data Inserted Successfully');


}

public function table(){
    $data=Blog::paginate(2);
    return view('backend.blog.table',compact('data'));


}
public function edit($id)
  {
    $data = Blog::find($id);
    return view('backend.blog.edit',compact('data'));
  }

  public function update(Request $request,$id){
    $data = Blog::find($id);
    $data->title = $request->title;
    $data->description = $request->description;
    if($request->hasFile('image'))
    {
        $file=$request->image;
        $extension=$file->getClientOriginalExtension();
        $filename=time().'.'.$extension;
        $file->move('uploads',$filename);
        $data->image=$filename;
    }
    $data->save();
    return redirect()->route('admin.blog.table')->with('msg','Data Updated Successfully');
    }
  public function delete($id)
  {
    $data = Blog::find($id);
    $data->delete();
    return redirect()->route('admin.blog.table')->with('msg','Data Deleted Successfully');
   }

}
