@extends("Frontier::layouts.admin")

@section("content")
    @include("Theme::partials.banner")

    <v-container fluid grid-list-lg>
        <v-layout row wrap justify-center align-center>
            <v-flex md8 sm10 xs12>

                {{-- @include("Form::templates.test") --}}

                <form action="{{ $resource->action ?? route('submissions.submit') }}" method="{{ $resource->method }}" {!! $resource->attributes !!}>
                   {{ csrf_field() }}
                   <input type="hidden" name="form_id" value="{{ $resource->id }}">
                   <input type="hidden" name="*%name%[field_id]*" value="%field_id%">
                   <input type="hidden" name="type" value="forms">

                   <v-card class="elevation-1">

                       <v-toolbar class="elevation-0">
                           <v-toolbar-title>{{ $resource->name }}</v-toolbar-title>
                       </v-toolbar>

                       @foreach ($resource->fields()->orderBy('sort')->get() as $label => $field)
                           <v-card-text>
                               <div class="mb-2">{!! html_entity_decode($field->template()->render()) !!}</div>
                           </v-card-text>
                       @endforeach

                       <v-card-actions>
                           <v-btn type="submit">{{ __('Submit') }}</v-btn>
                       </v-card-actions>
                   </v-card>
               </form>
            </v-flex>
        </v-layout>
    </v-container>
@endsection

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
                   },
                };
            },
        });
    </script>
@endpush
