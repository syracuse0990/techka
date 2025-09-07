<?php

namespace App\Http\Controllers\Web;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use App\Http\Requests\Web\Maintenance\MaintenanceRequest;
use App\Services\ImageService;

class MaintenanceController extends BaseController
{
    public function __construct(private ImageService $imageService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $for = $request->get('for');
        $meta_parent = $request->get('meta_parent');
        $meta_parent_id = $request->get('meta_parent_id');


        if($for){
            $model = Maintenance::query()->selectRaw('id');

            $per_page = $request->get('per_page');
            $sort_by = $request->get('sort_by');
            $sort_column = $request->get('sort_query');

            $date_column = $request->get('date_column');
            $start_date = $request->get('start_date');
            $to_date = $request->get('to_date');

            $search_term = $request->get('search_term');
            $keywords = $request->get('search');

            $columns = $request->get('columns');

            $model
            ->when(in_array('id', $columns), function ($query) {
                return $query->selectRaw('id');
            })
            ->when(in_array('meta_name', $columns), function ($query) {
                return $query->selectRaw('meta_name');
            })
            ->when(in_array('meta_value', $columns), function ($query) {
                return $query->selectRaw('meta_value');
            })
            ->selectRaw("meta_parent, meta_value, meta_array");

            $data = $model
            ->when($date_column, function ($query) use ($date_column, $start_date, $to_date) {
                return $query->whereBetween($date_column, [$start_date, $to_date]);
            })
            ->when($sort_column, function ($query) use ($sort_column, $sort_by) {
                $query->orderBy($sort_column, $sort_by);
            })
            ->where(function ($query) use ($search_term) {
                $query->where('meta_name', 'LIKE', '%' . $search_term . '%')
                    ->orWhere('meta_value', 'LIKE', '%' . $search_term . '%');
            })
            ->where('meta_parent', $meta_parent)
            ->where('meta_parent_id', $meta_parent_id)
            ->paginate($per_page);
        }else{

            $data = Maintenance::where('meta_parent', $meta_parent)->get();
        }


        return $this->sendResponse($data, "Maintenance data fetched.");
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(MaintenanceRequest $request)
    {
      $exists = Maintenance::where('meta_parent', $request->get('meta_parent'))->where('meta_value', $request->get('meta_value'))->where('meta_parent_id', $request->get('meta_parent_id'))->exists();
     if($exists && $request->get('meta_parent') !== "maintenance-itemtype"){
        return $this->sendError('Duplicate entry found.', [], 422);
     }
       $data = Maintenance::create([
        'meta_parent_id' => $request->get('meta_parent_id'),
        'meta_parent' => $request->get('meta_parent'),
        'meta_name' => $request->get('meta_name'),
        'meta_value' => $request->get('meta_value'),
        'meta_array' => $request->get('meta_array'),
       ]);

       return $this->sendResponse($data, "Entry created.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Maintenance $maintenance)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(MaintenanceRequest $request, Maintenance $maintenance)
    {
        $exists = Maintenance::where('meta_parent', $request->get('meta_parent'))->where('meta_value', $request->get('meta_value'))->where('meta_parent_id', $request->get('meta_parent_id'))->where('meta_name', $request->get('meta_name'))->exists();
        if($exists){
            return $this->sendError('Duplicate entry found.', [], 422);
        }
        $data = Maintenance::find($request->get('id'));
        $data->update($request->validated());
        return $this->sendResponse($data, "Entry updated.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        $maintenance->delete();
    }

    public function multipleMaintenance(Request $request)
        {
            $data = $request->get('form');
            $removeEntry = $request->get('removeEntry');
            foreach ($removeEntry as $item) {
                $deleteItem = Maintenance::find($item['id']);
                if ($deleteItem) {
                    $deleteItem->delete();
                }
            }


            $existingItems = Maintenance::whereIn('meta_parent', array_column($data, 'meta_parent'))
                ->whereIn('meta_value', array_column($data, 'meta_value'))
                ->whereIn('meta_parent_id', array_column($data, 'meta_parent_id'))
                ->whereIn('meta_name', array_column($data, 'meta_name'))
                ->get(['id', 'meta_parent', 'meta_value', 'meta_parent_id', 'meta_name'])
                ->toArray();


            foreach ($data as $item) {
                $exists = collect($existingItems)->contains(function ($existingItem) use ($item) {
                    return $existingItem['meta_parent'] == $item['meta_parent'] &&
                        $existingItem['meta_value'] == $item['meta_value'] &&
                        $existingItem['meta_parent_id'] == $item['meta_parent_id'] &&
                        $existingItem['meta_name'] == $item['meta_name'];
                });

                if ($exists && empty($item['id'])) {
                    return $this->sendError('Duplicate entry found.', [], 422);
                }
            }

            foreach ($data as $item) {
                if (isset($item['id']) && $item['id']) {
                    Maintenance::where('id', $item['id'])->update([
                        'meta_parent_id' => $item['meta_parent_id'],
                        'meta_parent' => $item['meta_parent'],
                        'meta_name' => $item['meta_name'],
                        'meta_value' => $item['meta_value'],
                    ]);
                } else {

                    Maintenance::create([
                        'meta_parent_id' => $item['meta_parent_id'],
                        'meta_parent' => $item['meta_parent'],
                        'meta_name' => $item['meta_name'],
                        'meta_value' => $item['meta_value'],
                    ]);
                }
            }

            return $this->sendResponse($data, "Data has been successfully inserted/updated");
        }


        public function fetchMultipleMaintenance(Request $request){
            $meta_parent_id = $request->get('meta_parent_id');
            $meta_parent = $request->get('meta_parent');

            $data = Maintenance::where('meta_parent_id',$meta_parent_id )->where('meta_parent', $meta_parent)->get();
            return $this->sendResponse($data, "multiple maintenance data.");
        }

        public function settingsMaintenance(Request $request){


            if($request->filled('id')){
                $logoName = $request->get('logo');
                if ($request->filled('logo') && preg_match('/^data:image\/(\w+);base64,/', $request->get('logo'))) {
                    $logoName = $this->imageService->processLogo($request->get('logo'));
                }
                $meta_array = $request->get('meta_array');
                $meta_array[0]['logo'] = $logoName;
                $item = Maintenance::find($request->get('id'));
                $data = $item->update([
                    'meta_parent_id' => $request->get('meta_parent_id'),
                    'meta_parent' => $request->get('meta_parent'),
                    'meta_name' => $request->get('meta_name'),
                    'meta_value' => $request->get('meta_value'),
                    'meta_array' => $meta_array,
                ]);
            }else{
                $logoName = "";
                if ($request->filled('logo')) {
                    $logoName = $this->imageService->processLogo($request->get('logo'));
                }
                $meta_array = $request->get('meta_array');
                $meta_array[0]['logo'] = $logoName;
                $data = Maintenance::create([
                    'meta_parent_id' => $request->get('meta_parent_id'),
                    'meta_parent' => $request->get('meta_parent'),
                    'meta_name' => $request->get('meta_name'),
                    'meta_value' => $request->get('meta_value'),
                    'meta_array' => $meta_array,
                ]);
            }


            return $this->sendResponse($data, "Data has been successfully inserted.");
        }

        // public function fetchBanks(Request $request){

        //     $data = Maintenance::where('meta_parent', $request->get('meta_parent'))->where('meta_parent_id', $request->get('project_id'))->get();

        //     return $this->sendResponse($data, "Bank lists.");
        // }

        public function getItemTypes(Request $request){
            $data = Maintenance::where('meta_parent', 'maintenance-itemtype')->where('meta_value', $request->get('type'))->get();
            $arr = [];

            foreach($data as $item){
                $arr [] = [
                    'value' => $item->id,
                    'title' => $item->meta_name,
                 ];
            }
            return $this->sendResponse($arr, "Item types");
        }

        public function fetchSingleMaintenance(Request $request){
            $data = Maintenance::where('meta_parent', $request->get('meta_parent'))->where('meta_parent_id', $request->get('project_id'))->get();

            return $this->sendResponse($data, "Maintenance Lists.");
        }
}
