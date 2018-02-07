@extends("Frontier::layouts.admin")

@section("content")
    @include("Theme::partials.banner")

    <v-toolbar light class="white sticky elevation-1 mb-2">
        <v-toolbar-title>{{ __('New Page') }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-btn primary ripple class="elevation-1" @click="$refs['form'].submit()">{{ __('Save') }}</v-btn>
        {{-- @include("Theme::cards.saving") --}}
    </v-toolbar>
    <v-container fluid grid-list-lg>
        <form ref="form" action="{{ route('pages.store') }}" method="POST">
            {{ csrf_field() }}
            <v-layout row wrap>
                <v-flex md9>
                    <v-card class="mb-3 elevation-1">

                        <v-card-text>
                            <v-text-field
                                name="title"
                                :error-messages="resource.errors.title"
                                label="{{ __('Title') }}"
                                v-model="resource.item.title"
                                @input="() => { resource.item.code = $options.filters.slugify(resource.item.title); }"
                            ></v-text-field>

                            <v-text-field
                                :append-icon-cb="() => (resource.readonly.slug = !resource.readonly.slug)"
                                :append-icon="resource.readonly.slug ? 'fa-lock' : 'fa-unlock'"
                                :readonly="resource.readonly.slug"
                                :value="resource.item.code | slugify"
                                label="{{ __('Code') }}"
                                name="code"
                                persistent-hint
                                :error-messages="resource.errors.code"
                                hint="{{ __("Code is used in generating URL. To customize the code, toggle the lock icon on this field.") }}"
                            ></v-text-field>
                        </v-card-text>

                        <v-divider></v-divider>

                        {{-- Editor --}}
                        @include("Page::interactive.editor")
                        {{-- /Editor --}}
                    </v-card>
                </v-flex>

                <v-flex md3>
                    {{-- @include("Theme::cards.saving") --}}

                    @include("Theme::interactives.featured-image")

                    @include("Page::cards.page-attributes")

                    @include("Category::cards.category")
                </v-flex>
            </v-layout>
        </form>
    </v-container>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ assets('frontier/vuetify-quill/dist/vuetify-quill.min.css') }}">
@endpush

@push('pre-scripts')
    <script src="{{ assets('frontier/vuetify-quill/dist/vuetify-quill.min.js') }}"></script>
    <script>
        mixins.push({
            data () {
                return {
                    resource: {
                        item: {
                            title: '{{ old('title') }}',
                            code: '{{ old('code') }}',
                            delta: '{!! old('delta') !!}',
                            body: '{!! old('body') !!}',
                            template: '{{ old('template') }}',
                            category_id: '{{ old('category_id') }}',
                        },
                        template: '{{ old('template') }}',
                        category_id: '{{ old('category_id') }}',
                        errors: {!! json_encode($errors->getMessages()) !!},
                        readonly: {
                            slug: true,
                        },
                        toggle: {
                            parent_id: false,
                        },
                        new: true,
                        misc: {
                            parent: {
                                title: 'None',
                            }
                        }
                    },
                    errors: {!! json_encode($errors->getMessages()) !!}
                }
            },
        })
    </script>
@endpush
