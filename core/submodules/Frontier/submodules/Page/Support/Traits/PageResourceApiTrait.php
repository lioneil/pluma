<?php

namespace Page\Support\Traits;

use Illuminate\Http\Request;
use Page\Models\Page;
use Page\Requests\PageRequest;
use User\Models\User;

trait PageResourceApiTrait
{
    /**
     * Retrieve the resource with the parameters.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function postFind(Request $request)
    {
        $parameters = $request->get('search') !== 'null' && $request->get('search')
                        ? $request->get('search')
                        : $request->all();

        $page = Page::search($parameters)->first();

        return response()->json($page);
    }

    /**
     * Retrieve list of resources.
     *
     * @param  Illuminate\Http\Request $request
     * @return Illuminate\Http\Response
     */
    public function getAll(Request $request)
    {
        $onlyTrashed = $request->get('only_trashed') !== 'null' && $request->get('only_trashed')
                        ? $request->get('only_trashed')
                        : false;

        $order = $request->get('descending') === 'true' && $request->get('descending') !== 'null'
                        ? 'DESC'
                        : 'ASC';

        $searches = $request->get('search') !== 'null' && $request->get('search')
                        ? $request->get('search')
                        : $request->all();

        $sort = $request->get('sort') && $request->get('sort') !== 'null'
                        ? $request->get('sort')
                        : 'id';

        $take = $request->get('take') && $request->get('take') > 0
                        ? $request->get('take')
                        : 0;

        $resources = Page::search($searches)->orderBy($sort, $order);

        if ($onlyTrashed) {
            $resources->onlyTrashed();
        }

        $pages = $resources->paginate($take);

        return response()->json($pages);
    }

    /**
     * Store a newly created resource in storage
     *
     * @param  Page\Requests\PageRequest $request
     * @return Illuminate\Http\Response
     */
    public function postStore(PageRequest $request)
    {
        $page = new Page();
        $page->title = $request->input('title');
        $page->code = $request->input('code');
        $page->feature = $request->input('feature');
        $page->body = $request->input('body');
        $page->delta = $request->input('delta');
        $page->template = $request->input('attributes')['template'] ?? 'generic';
        $page->user()->associate(User::find($request->input('user_id') ?? user()->id));
        $page->save();

        return response()->json($page->id);
    }

    /**
     * Retrieve the resource specified by the slug.
     *
     * @param  Illuminate\Http\Request $request
     * @param  string  $slug
     * @return Illuminate\Http\Response
     */
    public function getShow(Request $request, $slug = null)
    {
        $page = Page::codeOrFail($slug);

        return response()->json($page);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Role\Requests\RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function putUpdate(Request $request, $id)
    {
        $page = Page::findOrFail($id);
        $page->title = $request->input('title');
        $page->code = $request->input('code');
        $page->feature = $request->input('feature');
        $page->body = $request->input('body');
        $page->delta = $request->input('delta');
        $page->template = $request->input('template');
        $page->user()->associate(User::find($request->input('user_id')));
        $page->save();

        return response()->json($page->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDestroy(Request $request, $id = null)
    {
        $success = Page::destroy($request->has('id') ? $request->input('id') : $id);

        return response()->json($success);
    }

    /**
     * Restore the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postRestore(Request $request, $id = null)
    {
        $page = Page::onlyTrashed()->find($id);
        $page->exists() || $page->restore();

        if (is_array($request->input('id'))) {
            foreach ($request->input('id') as $id) {
                $page = Page::onlyTrashed()->find($id);
                $page->restore();
            }
        }

        return response()->json($success);
    }

    /**
     * Delete the specified resource from storage permanently.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteDelete(Request $request, $id = null)
    {
        $success = Page::forceDelete($id ? $id : $request->input('id'));

        return response()->json($success);
    }
}
