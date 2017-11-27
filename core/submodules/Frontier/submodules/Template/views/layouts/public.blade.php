@extends("Theme::layouts.master")

@section("pre-container", "")
@section("post-container", "")

@section("root")
    @include("Template::menus.main-menu")
    @yield("content")
    @include("Template::menus.social-menu")
@endsection
