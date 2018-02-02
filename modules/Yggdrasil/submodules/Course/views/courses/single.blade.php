@extends("Theme::layouts.public")

@section("head-title", $resource->title)

@section("content")
    <v-parallax class="elevation-1" src="{{ $resource->backdrop }}" height="480">
        <v-layout row wrap align-end justify-center>
            <v-flex md9 xs12 pa-0>
                <v-card tile flat class="mt-5" height="100%">
                    @if ($resource->enrolled)
                        <v-toolbar dense card class="white">
                            <v-spacer></v-spacer>
                            @if ($resource->enrolled)
                                <v-chip small class="ml-0 green white--text">{{ __('Enrolled') }}</v-chip>
                            @endif

                            @if ($resource->bookmarked)
                                <form action="{{ route('courses.bookmark.unbookmark', $resource->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    <v-btn type="submit" icon ripple v-tooltip:left="{ html: '{{ __('Remove from your Bookmarks') }}' }">
                                        <v-icon light class="red--text">bookmark</v-icon>
                                    </v-btn>
                                </form>
                            @endif

                            <v-menu full-width>
                                <v-btn slot="activator" icon><v-icon>more_vert</v-icon></v-btn>
                                <v-list>
                                    @can('bookmark-course')
                                        @if (! $resource->bookmarked)
                                            <v-list-tile avatar ripple @click="$refs.bookmark_form.submit()">
                                                <v-list-tile-avatar>
                                                    <v-icon class="red--text">bookmark_outline</v-icon>
                                                </v-list-tile-avatar>
                                                <v-list-tile-title>
                                                    <form ref="bookmark_form" action="{{ route('courses.bookmark', $resource->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ __('Bookmark this Course') }}
                                                    </form>
                                                </v-list-tile-title>
                                            </v-list-tile>
                                        @else
                                            <v-list-tile avatar ripple @click="$refs.unbookmark_form.submit()">
                                                <v-list-tile-avatar>
                                                    <v-icon class="red--text">bookmark</v-icon>
                                                </v-list-tile-avatar>
                                                <v-list-tile-title>
                                                    <form ref="unbookmark_form" action="{{ route('courses.bookmark.unbookmark', $resource->id) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ __('Remove from your Bookmarks') }}
                                                    </form>
                                                </v-list-tile-title>
                                            </v-list-tile>
                                        @endif
                                    @endcan
                                </v-list>
                            </v-menu>
                        </v-toolbar>
                    @endif
                    <v-container fluid pa-0>
                        <v-layout row wrap>
                            <v-flex md3 sm2>
                                <div class="pa-4">
                                    <img src="{{ $resource->feature }}" width="100%" height="auto">
                                </div>
                            </v-flex>
                            <v-flex md9 sm10>
                                <v-layout column wrap fill-height>
                                    <v-card-title primary-title class="page-title headline accent--text">
                                        <strong>{{ $resource->title }}</strong>
                                    </v-card-title>

                                    <v-card-text>
                                        <v-avatar size="30px">
                                            <img src="{{ $resource->author->avatar }}" alt="{{ $resource->author->fullname }}">
                                        </v-avatar>
                                        <v-chip label small class="ma-0 body-1 transparent grey--text elevation-0">
                                            <a href="{{ route('profile.single', $resource->author->handlename) }}">{{ $resource->author->fullname }}</a>
                                        </v-chip>
                                    </v-card-text>

                                    <v-spacer></v-spacer>

                                    <v-footer class="transparent">
                                        <v-chip label small class="ml-0 caption transparent grey--text elevation-0">
                                            <v-icon left small class="subheading">fa-tasks</v-icon>&nbsp;
                                            <span>{{ $resource->lessons->count() }} {{ $resource->lessons->count() <= 1 ? __('Part') : __('Parts') }}</span>
                                        </v-chip>

                                        <v-chip label small class="ml-0 caption transparent grey--text elevation-0"><v-icon left small class="subheading">class</v-icon><span>{{ $resource->code }}</span></v-chip>

                                        <v-chip label small class="ml-0 caption transparent grey--text elevation-0"><v-icon left small class="subheading">fa-clock-o</v-icon><span>{{ $resource->created }}</span></v-chip>

                                        @if ($resource->category)
                                            <v-chip label class="ml-0 caption transparent grey--text elevation-0"><v-icon left small class="subheading">label</v-icon><a target="_blank" href="{{ route('courses.all', ['category_id' => $resource->category->id]) }}">{{ $resource->category->name }}</a></v-chip>
                                        @endif
                                    </v-footer>
                                </v-layout>
                            </v-flex>
                        </v-layout>
                    </v-container>
                </v-card>
            </v-flex>
        </v-layout>
    </v-parallax>

    <v-container grid-list-lg>

        @include("Course::cards.evaluation")

        <v-layout row wrap>
            <v-flex flex md3 xs12 order-lg1>
                <v-card class="mb-3 elevation-1">
                    <v-toolbar card class="transparent">
                        <v-toolbar-title class="page-title accent--text">{{ __('Overview') }}</v-toolbar-title>
                    </v-toolbar>
                    <v-divider></v-divider>
                    <v-card-text class="grey--text text--darken-2 page-content body-1">{!! $resource->body !!}</v-card-text>
                </v-card>

                @includeIf("Badge::widgets.badge")
            </v-flex>

            <v-flex flex md6 xs12 order-lg2>
                {{-- Evaluation Form --}}
                {{-- @if ($resource->isDone()) --}}
                    {{-- <v-card dark class="elevation-1 mb-3 accent">
                        <v-toolbar dark card class="transparent">
                            <v-toolbar-title class="page-title">{{ __('Course Evaluation') }}</v-toolbar-title>
                            <v-spacer></v-spacer>
                            <v-btn icon><v-icon>close</v-icon></v-btn>
                        </v-toolbar>
                        <v-card-text class="body-1 text-xs-center">
                            <v-icon class="display-4 white--text text--darken-4">check</v-icon>
                            <p class="subheading">{{ __("You've finished this course! Yey!") }}</p>
                            <p>{{ __('How did we do? Let us know by answering this quick evaluation form.') }}</p>
                            <p>{{ __("It will only take a moment. Click the button below to start.") }}</p>
                            <v-btn target="_blank" primary href="">
                                {{ __('Start Course Feedback') }}
                                <sup>&nbsp;<v-icon class="caption">fa-external-link</v-icon></sup>
                            </v-btn>

                        </v-card-text>
                        <v-alert success v-show="'true'">{{ __('You are seeing this message because you have finished the course (yey!). Answering the evaluation survey form will help us improve it and its related topics.') }}</v-alert>
                    </v-card> --}}
                {{-- @endif --}}
                {{-- Evaluation Form --}}

                <v-card class="elevation-1 mb-3">
                    <v-toolbar class="teal white--text transparent elevation-1">
                        <v-toolbar-title class="page-title white--text">{{ __('Course Content') }}</v-toolbar-title>
                    </v-toolbar>

                    {{-- Empty Lessons --}}
                    @if ($resource->lessons->isEmpty())
                        <v-card-text class="text-xs-center pa-5">
                            <div><v-icon class="display-4 teal--text">fa-leaf</v-icon></div>
                            <div class="teal--text text--lighten-2">{{ __('No lessons available yet.') }}</div>
                        </v-card-text>
                    @endif
                    {{-- Empty Lessons --}}

                    {{-- Lessons --}}
                    @foreach ($resource->lessons()->orderBy('sort')->get() as $lesson)
                        <v-card-text :class="{'grey lighten-4': '{{ $lesson->locked }}' }">
                            <v-card flat tile class="transparent elevation-0">
                                <v-toolbar card class="transparent">
                                    @if ($lesson->locked)
                                        <v-icon left>lock</v-icon>
                                    @else
                                        <v-chip class="teal white--text">{{ $lesson->order }}</v-chip>
                                    @endif

                                    <v-toolbar-title class="accent--text body-2 page-title" :class="{'grey--text': '{{ $lesson->locked }}'}">
                                        <span>{{ $lesson->title }}</span>
                                    </v-toolbar-title>

                                    <v-spacer></v-spacer>

                                    @if ($lesson->icon)
                                        <v-chip label class="success white--text"><v-icon class="white--text">{{ $lesson->icon }}</v-icon></v-chip>
                                    @endif

                                    {{-- <v-chip label class="success white--text">{{ "{$lesson->completed}/{$lesson->contents->count()}" }}</v-chip> --}}
                                </v-toolbar>
                                <v-card-text class="grey--text text--darken-2 page-content body-1">
                                    {!! $lesson->body !!}
                                </v-card-text>

                                {{-- Lesson Content --}}
                                @if ($lesson->contents->count())
                                    <v-card-actions>
                                        <v-spacer></v-spacer>
                                        <v-dialog lazy fullscreen transition="dialog-bottom-transition" :overlay=false>
                                            @if ($resource->enrolled)
                                                <v-btn ref="dialog-{{ $lesson->id }}" slot="activator" outline class="teal teal--text">{{ __('Start') }}</v-btn>
                                            @else
                                                <v-btn ref="dialog-{{ $lesson->id }}" slot="activator" outline class="teal teal--text">{{ __('View') }}</v-btn>
                                            @endif
                                            <v-card flat tile class="bg--light">
                                                <v-parallax class="elevation-0 teal" src="{{ $lesson->feature }}" height="400">
                                                    <div class="media-overlay"></div>
                                                    <v-layout row wrap>
                                                        <v-spacer></v-spacer>
                                                        <v-btn dark flat icon ripple @click="$refs['dialog-{{ $lesson->id }}'].$el.click()"><v-icon>close</v-icon></v-btn>
                                                    </v-layout>
                                                    <v-layout column wrap align-center justify-center>
                                                        <v-flex sm12>
                                                            <v-card flat class="transparent">
                                                                <v-card-text class="white--text text-xs-center mb-5">
                                                                    <div class="display-2 page-title"><strong>{{ $lesson->title }}</strong></div>
                                                                </v-card-text>
                                                            </v-card>
                                                        </v-flex>
                                                        <v-spacer></v-spacer>
                                                    </v-layout>
                                                    <v-spacer></v-spacer>
                                                </v-parallax>

                                                <v-container grid-list-lg class="theme--light pb-5">
                                                    <v-layout row wrap>

                                                        {{-- Assignment --}}
                                                        <v-flex order-lg1 order-md1 order-sm3 order-xs3 md3 xs12>
                                                            <v-card class="elevation-1 card--filed-on-top">
                                                                <v-toolbar card class="transparent">
                                                                    <v-toolbar-title class="page-title subheading accent--text">{{ __('Assignment') }}</v-toolbar-title>
                                                                    <v-spacer></v-spacer>
                                                                </v-toolbar>

                                                                <v-divider></v-divider>

                                                                @if (is_null($lesson->assignment))
                                                                    <v-card-text class="pa-5 text-xs-center red--text text--lighten-3">
                                                                        <v-icon class="display-4 red--text text--lighten-3">content_copy</v-icon>
                                                                        <div label class="body-1">
                                                                            {!! __('No assignment<br>for this lesson.') !!}
                                                                        </div>
                                                                    </v-card-text>
                                                                @else
                                                                    <v-card-text class="pa-3 grey--text text--darken-2">
                                                                        <div class="mb-4"><strong>{{ $lesson->assignment->title }}</strong></div>
                                                                        <div class="page-content body-1">{!! $lesson->assignment->body !!}</div>
                                                                        <div class="text-xs-right">
                                                                            <v-icon left class="subheading">fa-edit</v-icon>
                                                                            {{ __('Deadline') }}: {{ $lesson->assignment->deadline }}
                                                                        </div>
                                                                        <v-card flat tile>
                                                                            llasd
                                                                        </v-card>
                                                                    </v-card-text>
                                                                @endif

                                                                @if ($lesson->assignment)
                                                                    <v-card-actions>
                                                                        <v-spacer></v-spacer>
                                                                        <v-btn disabled ripple v-tooltip.bottom="{html:'{{ __('Download Assignment') }}'}">
                                                                            <v-icon>file_download</v-icon>
                                                                            {{ __('Download') }}
                                                                        </v-btn>
                                                                    </v-card-actions>
                                                                @endif
                                                            </v-card>
                                                        </v-flex>
                                                        {{-- Assignment --}}

                                                        {{-- Content --}}
                                                        <v-flex order-lg2 order-md2 order-sm1 order-xs1 md6 xs12>
                                                            <v-card class="elevation-1 card--filed-on-top">
                                                                <v-toolbar card class="teal lighten-1">
                                                                    <v-toolbar-title class="page-title white--text">{{ __('Lesson Contents') }}</v-toolbar-title>
                                                                </v-toolbar>
                                                                <v-divider></v-divider>

                                                                <v-list three-line subheader class="pb-0">
                                                                    @foreach ($lesson->contents()->orderBy('sort')->get() as $content)
                                                                        {{-- Open Only But don't play --}}
                                                                        <v-list-tile avatar ripple target="_blank" href="{{ route('contents.single', [$content->course->slug, $lesson->id, $content->id]) }}">
                                                                            <v-list-tile-avatar>
                                                                                @if ($content->locked)
                                                                                    <v-icon class="grey--text">lock</v-icon>
                                                                                @elseif ($content->completed)
                                                                                    <v-icon class="teal lighten-3 white--text">check</v-icon>
                                                                                @else
                                                                                    <v-chip class="teal lighten-3 white--text">{{ $content->order }}</v-chip>
                                                                                @endif
                                                                            </v-list-tile-avatar>
                                                                            <v-list-tile-content>
                                                                                <v-list-tile-title class="title">{{ $content->title }}</v-list-tile-title>
                                                                                <v-list-tile-sub-title>
                                                                                    <em>{{ $content->excerpt }}</em>
                                                                                </v-list-tile-sub-title>
                                                                            </v-list-tile-content>
                                                                            <v-list-tile-action>
                                                                                <v-icon class="grey--text text--lighten-1">chevron_right</v-icon>
                                                                            </v-list-tile-action>
                                                                        </v-list-tile>
                                                                    @endforeach
                                                                </v-list>
                                                            </v-card>
                                                        </v-flex>
                                                        {{-- Content --}}

                                                        {{-- Progress --}}
                                                        <v-flex order-lg3 order-md3 order-sm2 order-xs2 md3 xs12 fill-height>
                                                            <div class="card--filed-on-top">
                                                                @include("Course::widgets.lesson-progress")
                                                            </div>
                                                        </v-flex>
                                                        {{-- Progress --}}
                                                    </v-layout>
                                                </v-container>
                                            </v-card>
                                        </v-dialog>
                                    </v-card-actions>
                                @endif
                                {{-- Lesson Content --}}
                            </v-card>
                        </v-card-text>
                        <v-divider></v-divider>
                    @endforeach
                    {{-- Lessons --}}
                </v-card>

                {{-- Comments Section --}}
                <v-card class="elevation-1">
                    @include("Course::widgets.comments")
                </v-card>
                {{-- Comments Section --}}
            </v-flex>

            <v-flex flex md3 xs12 order-lg3>
                {{-- Get Course --}}
                @include("Course::widgets.enrolled")
                {{-- Get Course --}}

                {{-- Course Progress --}}
                @include("Course::widgets.course-progress")
                {{-- Course Progress --}}

                {{-- Enrolled Students --}}
                @include("Course::widgets.students")
                {{-- Enrolled Students --}}
            </v-flex>
        </v-layout>
    </v-container>

@endsection

@push('css')
    <link rel="stylesheet" href="{{ assets('course/css/course.css') }}?v={{ app()->version() }}">
@endpush