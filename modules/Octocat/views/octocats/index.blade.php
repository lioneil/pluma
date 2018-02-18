@extends("Theme::layouts.public")

@section("content")
    @include("Theme::partials.banner")
    <v-container fluid grid-list-lg>
        <template>
            <div>
                <v-app>
                    <v-card class="elevation-1">
                        <v-toolbar
                            color="purple"
                            class="elevation-1"
                            dark
                            tabs
                            >
                            <v-text-field
                                prepend-icon="search"
                                append-icon="mic"
                                label="Search"
                                solo-inverted
                                class="mx-3"
                                flat
                            ></v-text-field>

                            <v-text-field
                                prepend-icon="search"
                                 appen-icon="mic"
                                 label="Search"
                                 solo-inverted
                            >
                            <v-tabs
                                slot="extension"
                                centered
                                v-model="tabs"
                                slider-color="white"
                                color="transparent"
                            >
                                <v-tab
                                    v-for="n in 3"
                                    :key="n"
                                >
                                    Item @{{ n }}
                                </v-tab>
                            </v-tabs>
                        </v-toolbar>

                        <v-tabs-items v-model="tabs">
                            <v-tab-item
                                v-for="n in 3"
                                :key="n"
                                >
                                <v-card>
                                    <v-card-text>
                                        @{{ text }}
                                    </v-card-text>
                                </v-card>
                            </v-tab-item>
                        </v-tabs-items>
                    </v-card>
                </v-app>
            </div>
        </template>
    </v-container>
@endsection

@push('css')
    <link href='https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons' rel="stylesheet">
    <link href="https://unpkg.com/vuetify/dist/vuetify.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, minimal-ui">
    <style>
        .search-bar label{
            padding-top: 8px;
            padding-bottom: 8px;
            padding-left: 25px !important;
        }
    </style>
@endpush

@push('pre-scripts')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.min.js"></script> --}}
    <script src="https://unpkg.com/vue/dist/vue.js"></script>
    <script src="https://unpkg.com/vuetify/dist/vuetify.js"></script>
    <script>
        // Vue.use(VueResource);

        mixins.push({
            data () {
                return {
                    tabs: null,
                    text: 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.'
                };
            },
        });
    </script>

@endpush