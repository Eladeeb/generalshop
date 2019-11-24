<?php

namespace App\Http\Controllers;

use App\Category;
use App\City;
use App\Country;
use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CountryController extends Controller
{
    public function index(){
        $countries=Country::paginate(env("PAGINATION_COUNT"));
        return view("admin.countries.countries")->with([
            "countries"=>$countries,
            'showLinks'=> true ,
        ]);
    }
    private function countryNameExists($countryName){
        $country=Country::where(
            'name','=',$countryName
        )->first();
        if( !is_null($country) ){
            Session::flash('message','Country ('.$countryName.') already exists');
            return false;
        }
        return true ;
    }
    private function capitalNameExists($capitalName){
        $capital=Country::where(
            'capital','=',$capitalName
        )->first();
        if( !is_null($capital) ){
            Session::flash('message','Capital ('.$capitalName.') already exists');
            return false;
        }
        return true ;
    }

    public function store(Request $request)
    {
        $request->validate([
            'country_name'=>'required',
            'capital_name'=>'required',

        ]);
        $countryName=$request->input('country_name');
        $capitalName=$request->input('capital_name');

        if(!$this->capitalNameExists($capitalName)){
            return back();
        }

        if(!$this->countryNameExists($countryName)){
            return back();
        }

        $newCountry = new Country();
        $newCountry ->name =$countryName;
        $newCountry->capital=$capitalName;
        $newCountry ->save();
        Session::flash('message','Country '.$newCountry ->name.' has been added');
        return back();

    }
    public function search(Request $request){
        $request->validate([
            'country_search'=>'required',
        ]);
        $searchTerm=$request->input('country_search');
        $countries=Country::where(
            'name','LIKE','%'.$searchTerm.'%'
        )->orWhere(
            'capital','LIKE','%'.$searchTerm.'%'

        )->get();


        if( count($countries) > 0 ){
            return view('admin.countries.countries')->with([
                'countries'=>$countries ,
                'showLinks'=> false ,
            ]);

        }


        Session::flash('message','Nothing Found!!!');
        return redirect()->back();
    }
    public function update(Request $request)
    {

        $request->validate([
            'country_id'=>'required',
            'country_name'=>'required',
            'capital_name'=>'required',
        ]);

        $countryName=$request->input('country_name');
        $capitalName=$request->input('capital_name');

        if(!$this->countryNameExists($countryName)){
            return redirect()->back();
        }
        if(!$this->capitalNameExists($capitalName)){
            return redirect()->back();
        }


        $countryID=intval($request->input('country_id'));
        $country=Country::find($countryID);
        $country->name =$request->input('country_name');
        $country->capital=$request->input('capital_name');
        $country->save();
        Session::flash('message','Unit '.$country->name.' has been updated');
        return redirect()->back();

    }

    public function delete(Request $request)
    {
        if(is_null($request->input('country_id')) || empty($request->input('country_id'))){

            Session::flash('message','Country ID is required');
            return redirect()->back();
        }
        $id=$request->input('country_id');
        Country::destroy($id);
        Session::flash('message','Country has been deleted');
        return redirect()->back();
    }




}
