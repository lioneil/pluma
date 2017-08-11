<?php

namespace Role\API\Controllers;

use Illuminate\Http\Request;
use Pluma\API\Controllers\APIController;
use Role\Models\Grant;
use Role\Models\Permission;

class GrantController extends APIController
{
    /**
     * Search the resource.
     *
     * @param  Request $request
     * @return Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $search = $request->get('q') !== 'null' && $request->get('q') ? $request->get('q'): '';
        $take = $request->get('take') && $request->get('take') > 0 ? $request->get('take') : 0;
        $sort = $request->get('sort') && $request->get('sort') !== 'null' ? $request->get('sort') : 'id';
        $order = $request->get('descending') === 'true' && $request->get('descending') !== 'null' ? 'DESC' : 'ASC';
        $onlyTrashed = $request->get('trashedOnly') !== 'null' && $request->get('trashedOnly') ? $request->get('trashedOnly'): false;

        $grants = Grant::search($search)->orderBy($sort, $order);
        if ($onlyTrashed) {
            $grants->onlyTrashed();
        }
        $grants = $grants->paginate($take);

        return response()->json($grants);
    }

    /**
     * Get all resources.
     *
     * @param  Illuminate\Http\Request $request [description]
     * @return Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $search = $request->get('q') !== 'null' && $request->get('q') ? $request->get('q'): '';
        $take = $request->get('take') && $request->get('take') > 0 ? $request->get('take') : 0;
        $sort = $request->get('sort') && $request->get('sort') !== 'null' ? $request->get('sort') : 'id';
        $order = $request->get('descending') === 'true' && $request->get('descending') !== 'null' ? 'DESC' : 'ASC';

        $permissions = Grant::search($search)->orderBy($sort, $order)->paginate($take);

        return response()->json($permissions);
    }

    /**
     * Get all resources.
     *
     * @param  Illuminate\Http\Request $request [description]
     * @return Illuminate\Http\Response
     */
    public function getTrash(Request $request)
    {
        $search = $request->get('q') !== 'null' && $request->get('q') ? $request->get('q'): '';
        $take = $request->get('take') && $request->get('take') > 0 ? $request->get('take') : 0;
        $sort = $request->get('sort') && $request->get('sort') !== 'null' ? $request->get('sort') : 'id';
        $order = $request->get('descending') === 'true' && $request->get('descending') !== 'null' ? 'DESC' : 'ASC';

        $permissions = Grant::search($search)->orderBy($sort, $order)->onlyTrashed()->paginate($take);

        return response()->json($permissions);
    }

    /**
     * Gets the permissions.
     *
     * @param  array $modules
     * @return void
     */
    public function permissions($modules = null)
    {
        $permissions = Permission::all();

        $p = [];
        foreach ($permissions as $i => $permission) {
            $p[$permission->grants()->first() ? $permission->grants()->first()->name : 'Uncategorized'][] = $permission;
        }

        return response()->json($p);
    }
}