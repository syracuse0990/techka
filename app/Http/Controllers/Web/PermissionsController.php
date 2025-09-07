<?php

namespace App\Http\Controllers\Web;

use App\Models\Permissions;
use App\Http\Requests\Web\RolesPermissions\PermissionRequest;
use Illuminate\Http\Request;

class PermissionsController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if($request->filled('role_id')){
            $permission = Permissions::where('maintenance_role_id', $request->get('role_id'))->first();

            $data = $permission->data_array ?? [];
        }else{
            $data = Permissions::all();
        }

       return $this->sendResponse($data, "Permission lists.");
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
    public function store(PermissionRequest $request)
    {
        $roleIDexists = Permissions::where('maintenance_role_id', $request->get('role_id'))->first();

        if($roleIDexists){

            $roleIDexists->update([
                'data_array' => $request->get('permissions'),
            ]);
            $data = $roleIDexists;
        }else{
            $data = Permissions::create([
                'maintenance_role_id' => $request->get('role_id'),
                'data_array' => $request->get('permissions'),
            ]);
        }

        return $this->sendResponse($data, "Permission created.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Permissions $permissions)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Permissions $permissions)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Permissions $permissions)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Permissions $permissions)
    {
        //
    }
}
