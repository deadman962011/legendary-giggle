<?php

namespace App\Http\Controllers\cp;

use Exception;
use App\Models\Zone;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\cp\zone\saveZoneRequest;
use App\Models\ZoneTranslation;
use Illuminate\Support\Facades\DB;
use MatanYadaev\EloquentSpatial\Objects\Point;
use MatanYadaev\EloquentSpatial\Objects\Polygon;
use MatanYadaev\EloquentSpatial\Objects\LineString;
// use App\Models\Incentive;
// use App\Exports\ZoneExport;
// use App\Models\Translation;
// use App\CentralLogics\Helpers;
// use Brian2694\Toastr\Facades\Toastr;
// use Maatwebsite\Excel\Facades\Excel;
// use Rap2hpoutre\FastExcel\FastExcel;
// use Illuminate\Support\Facades\Validator;

class ZoneController extends Controller
{
    public function List(Request $request)
    {
        $zones = Zone::where('isDeleted',false)->get();
        return view('zone.list', compact('zones'));
    }

    public function Create() {
        
        return view('zone.new');

    }

    public function Store(saveZoneRequest $request){
        try {
            
            DB::beginTransaction();   
            
            $value = $request->coordinates;
            foreach(explode('),(',trim($value,'()')) as $index=>$single_array){
                if($index == 0)
                {
                    $lastcord = explode(',',$single_array);
                }
                $coords = explode(',',$single_array);
                $polygon[] = new Point($coords[0], $coords[1]);
            }
            $polygon[] = new Point($lastcord[0], $lastcord[1]);
            $coordinates=new Polygon([new LineString($polygon)]);
            $saveZone= new Zone();
            $saveZone->name=$request->{'name_'.$request->lang[0]};
            $saveZone->coordinates=$coordinates;
            $saveZone->save();            
 

            for ($i=0; $i < count($request->lang); $i++) { 
                //save zone translations
                ZoneTranslation::create([
                    'key'=>'name',
                    'value'=>$request->{'name_'.$request->lang[$i]},
                    'lang' =>$request->lang[$i], 
                    'zone_id' => $saveZone->id
                ]);
            }

            DB::commit();

            return response()->json([
                'success'=>true,
                'message'=>'Zone successfully saved',
                'action'=>'redirect_to_url',
                'action_val'=>route('zone.list')
            ]);
            

        } catch (\Throwable $th) {
            dd($th);
            DB::rollBack();
            return response()->json([
                'success'=>false,
                'message'=>'Somthing Went Wrong'
            ]);
        }







        dd($coordinates);

    }


    public function UpdateStatus(Request $request) {
        

        //
        $updateZone=Zone::findOrFail($request->id);
        $updateZone->update([
            'status'=>!$updateZone->status
        ]);
        
        return response()->json([
            'success'=>true,
            'message'=>__('zone_status_successfully_updated')
        ],200);

    }



    public function GetCoordinate(Request $request)  {
        
        
        $zone=Zone::withoutGlobalScopes()->selectRaw("*,ST_AsText(ST_Centroid(`coordinates`)) as center")->findOrFail($request->id);
        $area = json_decode($zone->coordinates[0]->toJson(),true);
        $formatted_coordinates=[];
        foreach ($area['coordinates'] as $coord) {
            $formatted_coordinates[] = (object)['lat' => $coord[1], 'lng' => $coord[0]];
        } 
 
        $center = (object)['lat'=>(float)trim(explode(' ',$zone->center)[1], 'POINT()'), 'lng'=>(float)trim(explode(' ',$zone->center)[0], 'POINT()')];
        return response()->json(['coordinates'=>$formatted_coordinates, 'center'=>$center]);

    }





}