@extends("Theme::layouts.admin")

@section("content")
    @include("Theme::partials.banner")

    {{-- Location: dashboard.1.12 --}}
    {{-- Location: dashboard.1.12 --}}

    {{-- Location: dashboard.2.12 --}}
    <v-container fluid grid-list-lg>
        @include("Dashboard::widgets.glance")

        <v-card class="elevation-0 transparent my-2">
            <v-card-text class="px-0">
                <p class="title">{{ __("Hey there, " . user()->firstname . "!") }}</p>
                <div>{{ __("Here's some things to note since you left.") }}</div>
            </v-card-text>
        </v-card>

        <v-layout row wrap>
            <v-flex xs12 sm6 md4>
                @foreach (widgets("dashboard.2.1", "location") as $widget)
                    @include($widget->view)
                @endforeach
            </v-flex>

            <v-flex xs12 sm6 md4>
                @foreach (widgets("dashboard.2.2", "location") as $widget)
                    @include($widget->view)
                @endforeach
            </v-flex>

            <v-flex xs12 sm6 md4>
                @foreach (widgets("dashboard.2.3", "location") as $widget)
                    @include($widget->view)
                @endforeach
            </v-flex>
        </v-layout>
    </v-container>
    {{-- Location: dashboard.2.12 --}}
@endsection

@push('css')
    <style>
        .inline {
            display: inline-block;
        }
        .overlay-bg {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .media .card__text,
        .top-level {
            z-index: 1;
        }
        .weight-600 {
            font-weight: 600 !important;
        }
        .progress-circular{
            margin: 1rem;
        }
    </style>
@endpush

@push('pre-scripts')
    <script src="{{ assets('frontier/vendors/vue/draggable/sortable.min.js') }}"></script>
    <script src="{{ assets('frontier/vendors/vue/draggable/draggable.min.js') }}"></script>
    <script src="{{ assets('frontier/vendors/vue/dist/vue-resource.min.js') }}"></script>
    <script>
        Vue.use(VueResource);
        mixins.push({
            data () {
                return {
                    draggables: {
                        items: [
                            { name: 'yas', active: 'true' },
                        ],
                    },
                }
            },
            beforeDestroy () {
                // clearInterval(this.interval)
            },
        })
    </script>
@endpush
