<?php

namespace Course\Controllers;

use Content\Models\Content;
use Course\Models\Course;
use Course\Models\User;
use Frontier\Controllers\AdminController;
use Illuminate\Http\Request;

class EnrollController extends AdminController
{
    /**
     * Display a listing of the resource.
     *
     * @param  Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        /**
         * Use the Course\Models\User instead
         * of the default User\Models\User.
         * In this way we have access to the course_user relationship.
         *
         * @var \Course\Models\User $user
         */
        $user = User::find(user()->id);
        $resources = $user->courses;

        // dd($resources[0]->bookmarked);

        return view("Theme::enrolled.index")->with(compact('resources'));
    }

    /**
     * Show the detail form of the course to be enrolled.
     * @param  \Illuminate\Http\Request $request
     * @param  int  $slug
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $slug)
    {
        $resource = Course::whereSlug($slug)
            ->with('lessons.contents')
            ->firstOrFail();

        return view("Theme::courses.show")->with(compact('resource'));
    }

    /**
     * Request for an Enrollment to a given Course.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function request(Request $request, $id)
    {
        # code...
    }

    /**
     * Enrolls the user into a resource (e.g. Course).
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int  $course_id
     * @param  int $user_id
     * @return \Illuminate\Auth\Access\Response
     */
    public function enroll(Request $request, $course_id, $user_id)
    {
        $course = Course::findOrFail($course_id);
        Course::enrollUser($course_id, $user_id);


        die("OKAY");
    }
}
