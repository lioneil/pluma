<?php

namespace Course\Support\Traits;

use Course\Mail\CourseRequested;
use Course\Models\Course;
use Course\Models\Student;
use Course\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

trait MyCourseResourceTrait
{
    /**
     * Retrieve list of all resources.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function current(Request $request)
    {
        $resources = Student::findOrFail(user()->id)
                            ->courses()
                            ->search($request->all())
                            ->paginate();

        if ($request->ajax()) {
            return response()->json($resources);
        }

        return view("Theme::courses.my")->with(compact('resources'));
    }

    /**
     * View list of bookmarked courses.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function bookmarked(Request $request)
    {
        $resources = Course::onlyBookmarkedBy(user())
                           ->search($request->all())
                           ->paginate();

        if ($request->ajax()) {
            return response()->json($resources);
        }

        return view("Theme::courses.bookmarked")->with(compact('resources'));
    }

    /**
     * Request for the given resource.
     *
     * @param \Illuminate\Http\Request $request
     * @param int  $id
     * @return \Illuminate\Http\Response
     */
    public function request(Request $request, $id)
    {
        $course = Course::findOrFail($id);
        $course->users()->attach($request->input('user_id'),
            ['status' => 'pending', 'enrolled_at' => null]
        );

        // Send Email
        # to student
        // $student = User::find($request->input('user_id'));
        // Mail::to($student->email)
        //     ->send(new CourseRequested($course, $student));

        return back();
    }
}
