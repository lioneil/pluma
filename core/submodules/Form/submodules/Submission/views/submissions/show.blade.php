@extends("Frontier::layouts.admin")

@section("content")
    @include("Theme::partials.banner")

    <v-toolbar dark extended class="light-blue elevation-0">
        <v-btn
            href="{{ route('submissions.index') }}"
            ripple
            flat
            >
            <v-icon left dark>arrow_back</v-icon>
            Back
        </v-btn>
    </v-toolbar>

    <v-container fluid>
        <v-layout row wrap>
            <v-flex xs12>
                <v-card flat class="transparent">
                    <v-layout row wrap>
                        <v-flex md8 offset-md2 xs12>
                            <v-card class="card--flex-toolbar">
                                <v-toolbar card prominent class="transparent">
                                    <v-toolbar-title class="title">{{ __($resource->form->name) }}</v-toolbar-title>
                                    <v-spacer></v-spacer>


                                    {{-- EXPORT --}}
                                    <form action="{{ route('submissions.export', $resource->id) }}" method="POST">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="export_type" value="pdf">
                                        <v-btn primary type="submit" class="elevation-1 white--text">
                                            <v-icon left>fa-file-pdf-o</v-icon>
                                            {{ __('Export') }}
                                        </v-btn>
                                    </form>
                                    {{-- EXPORT --}}



                                </v-toolbar>
                                <v-divider></v-divider>
                                <v-card-text class="body-1">
                                    <v-card-actions class="pa-0">
                                        <div>
                                            <v-avatar size="25px">
                                                <img src="{{ $resource->user->avatar }}">
                                            </v-avatar>
                                            <span class="pl-2">{{ $resource->user->displayname }}</span>
                                        </div>
                                        <v-spacer></v-spacer>
                                        <v-icon>schedule</v-icon>
                                        <span>{{ $resource->created }}</span>
                                    </v-card-actions>
                                </v-card-text>

                                {{-- questions --}}
                                <v-card-text class="pa-4">
                                    @foreach ($resource->fields() as $field)
                                        <div class="fw-500"><v-icon class="mr-2 pb-1" style="font-size: 10px;">lens</v-icon> {{ $field->question->label }}</div>
                                        <div class="pa-3 grey--text text--darken-1" style="padding-left: 21px !important;">{{ "You answered " . $field->guess }}</div>
                                        <div class="pa-3 grey--text text--darken-1" style="padding-left: 21px !important;">{{ "Correct answer is " . $field->answer }}</div>
                                        <div class="pa-3 grey--text text--darken-1" style="padding-left: 21px !important;">{{ "You answered " . ($field->isCorrect ? 'correctly' : 'wrongly') }}</div>

                                    @endforeach
                                </v-card-text>
                            </v-card>
                        </v-flex>
                    </v-layout>
                </v-card>
            </v-flex>
        </v-layout>
    </v-container>
@endsection

@push('css')
    <style>
        .card--flex-toolbar {
            margin-top: -80px;
        }
        .fw-500 {
            font-weight: 500 !important;
        }
    </style>
@endpush

@push('pre-scripts')
    <script src="{{ assets('frontier/vendors/vue/resource/vue-resource.min.js') }}"></script>
    <script>
        Vue.use(VueResource);

        mixins.push({
            data () {
                return {
                    resource: {
                       item: {!! json_encode(old() ?? []) !!},
                       errors: {!! json_encode($errors->getMessages()) !!},
                       results: {!! json_decode('results') !!}
                   },
                };
            },
        });
    </script>
@endpush
