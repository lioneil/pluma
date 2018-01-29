{{-- Editor --}}
<v-quill
    paper
    :options="{
        placeholder: '{{ __('Write something...') }}',
    }"
    :toolbar-options="[
        [{'header':1},{'header':2}],
        ['bold','italic','underline','strike'],
        [{'align':''},{'align':'center'},{'align':'right'},{'align':'justify'}],
        ['blockquote','code-block'],
        [{'list':'ordered'},{'list':'bullet'}],
        [{'indent':'-1'},{'indent':'+1'},'image'],
    ]"
    class="elevation-0"
    class="mb-3 card--flat white elevation-1"
    v-model="resource.quill"
>
    <template>
        <input type="hidden" name="body" :value="resource.quill.html">
        <input type="hidden" name="delta" :value="JSON.stringify(resource.quill.delta)">
    </template>
</v-quill>
{{-- /Editor --}}

@push('css')
    <link rel="stylesheet" href="{{ assets('frontier/vuetify-quill/dist/vuetify-quill.min.css') }}">
@endpush

@push('pre-scripts')
    <script src="{{ assets('frontier/vuetify-quill/dist/vuetify-quill.min.js') }}"></script>
    <script>
        // Vue.use(VueResource);
        mixins.push({
            data () {
                return {
                    resource: {
                        quill: {
                            html: '{!! old('body') !!}',
                            delta: JSON.parse({!! json_encode(old('delta')) !!}),
                        }
                    },
                    mediabox: {
                        model: false,
                        fonts: {!! json_encode(config('editor.fonts.enabled', [])) !!},
                        url: '',
                        resource: {
                            thumbnail: '',
                        },
                    },
                }
            },
        })
    </script>
@endpush
