{{--
Template Name: Home Template
Description: The default home template displaying the title, body, and featured image of the page.
Author: John Lioneil Dionisio
Version: 1.0
--}}

@extends("Template::layouts.public")

@section("content")

    @include("Template::menus.main-menu")

    <v-parallax class="primary accent-3 white--text" :height="280" src="{{ $page->feature }}"></v-parallax>

    <v-container fluid grid-list-lg>
        <v-layout row wrap>
            <v-flex sm12>
                <v-card class="elevation-1">
                    <v-card-text>
                        {!! $page->body !!}
                    </v-card-text>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
@endsection
