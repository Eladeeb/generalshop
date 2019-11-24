<?php

namespace App\Http\Controllers;

use App\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DataImportController extends Controller
{
    public function importUnites()
    {
        $units = [
            "AS" => "Assortment",
            "BG" => "Bag",
            "BA" => "Bale",
            "BI" => "Bar",
            "BR" => "Barrel",
            "BL" => "Block",
            "BB" => "Board",
            "BF" => "Board Feet",
            "BO" => "Bottle",
            "Bx" => "Box",
            "BN" => "Bulk",
            "BD" => "Bundle",
            "BU" => "Bushel",
            "CN" => "Can",
            "CG" => "Card",
            "CT" => "Carton",
            "CQ" => "Cartridge",
            "CA" => "Case",
            "C3" => "Centigram",
            "CM" => "Centiliter",
            "1N" => "Count",
            "CV" => "Cover",
            "CC" => "Cubic Centimeter",
            "CB" => "Cubic Decimeter",
            "CF" => "Cubic Feet",
            "CI" => "Cubic Inches",
            "CR" => "Cubic Meter",
            "Cq" => "Cubic Meters (Net)",
            "MMq" => "Cubic Milimeter",
            "CU" => "Cup",
            "DA" => "Days",
            "DG" => "Decigram",
            "DL" => "Deciliter",
            "DM" => "Decimeter",
            "CE" => "Degrees Celsius (Centigram)",
            "FA" => "Degrees Fahrenheit",
            "DS" => "Display",
            "DO" => "Dollars US",
            "DZ" => "Dozen",
            "DR" => "Drum",
            "EA" => "Each",
            "EV" => "Envelope",
            "FT" => "Feet",
            "UZ" => "Fifty Country",
            "UY" => "Fifty Square Feet",
            "FQ" => "Fluid Qunce",
            "GA" => "Gallon",
            "GR" => "Gram",
            "GT" => "Gross Kilogram",
            "GH" => "FDgrreg",
            "HGD" => "Ggregrg",
            "Gg" => "Gegtgr",
            "TR" => "Grtt",
            "YU" => "Ghtrh",
            "HT" => "Thtry",
            "HJ" => "Jrhthy",
            "GFH" => "Yrhthry",
            "WE" => "Ftrhy",
            "QRE" => "Gtryh",
            "TL" => "Sbtjyt",
            "RT" => "Thnytjy",
            "XC" => "Dgtht",
            "YB" => "Yjkuyk",
            "YO" => "Dgdgr",
            "TH" => "Dfgreg",
            "TG" => "Ygfgh",
            "TB" => "Bgdht",
            "YJ" => "Yfgrhty",
            "NM" => "Hdsfewfrwe",
            "PO" => "Peter",
            "PL" => "Prsfre",
            "PK" => "Pefwfreg",
            "PI" => "Prggreg",
            "PG" => "Pqwfergetg",
            "BE" => "Bewregr",
            "OP" => "Owerfewf4r",
            "OI" => "Oawdwd",
            "OU" => "Oqweefe",
            "OK" => "Orfwef",
            "OT" => "Oretrh",
            "NF" => "Nrege",
            "NV" => "Nregeg",
            "NH" => "Newr4",
            "JK" => "Jewfew",
            "JU" => "Jewrfef",
            "XA" => "Xade",
            "XS" => "Xtrgr",
            "XD" => "Xegre",
            "WZ" => "Wdgrtg",
            "WQ" => "Wbgrhtr",
            "WR" => "QuaryDry",
            "ZX" => "Roll",
            "ST" => "Set",
            "SH" => "Sheet",
            "SX" => "Shipment",
            "SJ" => "Sizing Factor",
            "SF" => "Square Foot",
            "Sm" => "Square Meter",
            "SY" => "Square Yard",
            "15" => "Stick",
            "TK" => "Tank",
            "Tm" => "Thousand Feet",
            "TE" => "Tote",
            "NT" => "Trailer",
            "TY" => "Try",
            "Z25" => "Usage",
            "UN" => "Unit",
            "YD" => "Yard",

        ];

        //Foreach($units as $key => $value){
        //  DB::table('units')->insert([
        //    'unit_code'=>$key ,
        //  'unit_name'=>$value,
        //'created_at'=>now(),
        //'updated_at'=>now(),
        //]);

        //  }
        Foreach ($units as $key => $value) {
            $unit = new Unit();
            $unit->unit_code =$key ;
            $unit->unit_name=$value;
            $unit->save();

        }
    }
}
