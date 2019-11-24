<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    public function index(){
        $categories =Category::paginate(env("PAGINATION_COUNT"));
        return view('admin.categories.categories')->with([
            'categories'=>$categories,
            'showLinks'=> true ,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'category_name'=>'required',
            'category_image'=>'required',
            'image_direction'=>'required',

        ]);
        $categoryName=$request->input('category_name');
        if(!$this->categoryNameExists($categoryName)){
            return back();
        }
        $newCategory = new Category();
        $newCategory->name =$categoryName;
        $newCategory->image_direction = $request->input('image_direction');
        if ( $request->hasFile('category_image')){

            $images = $request->file('category_image');
             // $path = $image->store('public');

                //$image->url = $path;
                //$image->product_id = $product->id;
                //$image->save();
                $destination = 'images';
                $filename = $images->getClientOriginalName();
                $path = 'images/'.$filename;
                $newCategory->image_url = $path;
                $images->move($destination,$filename);

        }
        $newCategory->save();
        Session::flash('message','Category '.$newCategory->name.' has been added');
        return back();

    }
    public function search(Request $request){
        $request->validate([
            'category_search'=>'required',
        ]);
        $searchTerm=$request->input('category_search');
        $categories=Category::where(
            'name','LIKE','%'.$searchTerm.'%'
        )->get();


        if( count($categories) > 0 ){
            return view('admin.categories.categories')->with([
                'categories'=>$categories ,
                'showLinks'=> false ,
            ]);

        }

        Session::flash('message','Nothing Found!!!');
        return redirect()->back();
    }
    public function delete(Request $request)
    {
        $request->validate([
            'category_id'=>'required'
        ]);
        $categoryID = $request->input('category_id');
        Category::destroy($categoryID);

        Session::flash('message','Category has been deleted');
        return redirect()->back();
    }
    public function update(Request $request)
    {

        $request->validate([
            'category_name'=>'required',
            'category_id'=>'required',
        ]);

        $categoryName=$request->input('category_name');
        $categoryID=$request->input('category_id');
        if(!$this->categoryNameExists($categoryName)){
            Session::flash('message','Tag Name ('.$categoryName.') already exists');
            return redirect()->back();
        }


        $category=Tag::find($categoryID);
        $category->name =$categoryName;
        $category->save();
        Session::flash('message','Unit '.$categoryName.' has been updated');
        return redirect()->back();

    }
    private function categoryNameExists($categoryName){
        $category=Category::where(
            'name','=',$categoryName
        )->first();
        if( !is_null($category) ){
            Session::flash('message','Tag Name ('.$categoryName.') already exists');
            return false;
        }
        return true ;
    }

}
