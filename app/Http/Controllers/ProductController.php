<?php

namespace App\Http\Controllers;

use App\Category;
use App\Image;
use App\Product;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller
{
    public function index(){
        $products =Product::with(['category','images'])->paginate(env("PAGINATION_COUNT"));
        $currency_code= env("CURRENCY_CODE","$");
        return view('admin.products.products')->with(['products'=>$products,
            "currency_code"=>$currency_code
        ]);
    }
    private function writeProduct(Request $request , Product $product,$update = false){

        $product->title=$request->input('product_title');
        $product->description=$request->input('product_description');
        $product->unit=intval($request->input('product_unit'));
        $product->price=doubleval($request->input('product_price'));
        $product->total=doubleval($request->input('product_total'));
        $product->category_id = intval($request->input('product_category'));
        $product->discount=doubleval($request->input('product_discount'));
        if ($request->has('options')){
            $optionArray = [];
            $options = array_unique($request->input('options'));

            foreach ( $options as $option){
                $actualOptions = $request->input($option);
                $optionArray[ $option] = [];
                foreach ( $actualOptions as $actualOption){

                    array_push( $optionArray[ $option] , $actualOption) ;
                }
            }

            $product->options =json_encode( $optionArray);
        }
        $product->save();

        if ( $request->hasFile('product_images')){

            $images = $request->file('product_images');

            foreach ( $images as $image){
                // $path = $image->store('public');

                //$image->url = $path;
                //$image->product_id = $product->id;
                //$image->save();
                $destination = 'images';
                $iImage = new Image();
                $filename = $image->getClientOriginalName();
                $path = 'images/'.$filename;
                $iImage->url = $path;
                $iImage->product_id = $product->id;
                $image->move($destination,$filename);
                $iImage->save();
            }
        }
        return $product ;
    }
    public function store(Request $request)
    {
        $request->validate([
            'product_title'=>'required',
            'product_description'=>'required',
            'product_unit'=>'required',
            'product_price'=>'required',
            'product_discount'=>'required',
            'product_total'=>'required',
            'product_category'=>'required',
        ]);


        $product = new Product();
        $this->writeProduct($request,$product);


        Session::flash('message','product has been added');
        return redirect(route('products'));
    }
    public function update(Request $request)
    {
        $request->validate([
            'product_title'=>'required',
            'product_description'=>'required',
            'product_unit'=>'required',
            'product_price'=>'required',
            'product_discount'=>'required',
            'product_total'=>'required',
            'product_category'=>'required',
        ]);
        $productID = $request->input('product_id');
        $product=Product::find($productID);
        $this->writeProduct($request,$product,true);
        Session::flash('message','product has been UPDATE');
        return back();

    }
    public function newProduct($id = null)
    {
        $product = null;
        if (!is_null($id)) {
            $product = Product::with([
                'hasUnit',
                'category'
            ])->find($id);

        }

        $units = Unit::all();
        $categories = Category::all();

        return view('admin.products.new-product')->with([
            'product' => $product,
            'units' => $units,
            'categories' => $categories,

        ]);
    }
    public function deleteImage(Request $request){
        $imageID=$request->input('image_id');
        Image::destroy($imageID);
    }
}
