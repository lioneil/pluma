@extends("Frontier::layouts.admin")

@section("content")

    <v-toolbar dark class="light-blue elevation-1 sticky">
        <v-toolbar-title primary-title>{{ __($application->page->title) }}</v-toolbar-title>
        <v-spacer></v-spacer>

        {{-- Search --}}
        <template>
            <v-text-field
                :append-icon-cb="() => {dataset.searchform.model = !dataset.searchform.model}"
                :prefix="dataset.searchform.prefix"
                :prepend-icon="dataset.searchform.prepend"
                append-icon="close"
                light solo hide-details single-line
                label="Search"
                v-model="dataset.searchform.query"
                v-show="dataset.searchform.model"
            ></v-text-field>
            {{--  <v-select
                label="Search"
                chips
                tags
                solo
                prepend-icon="search"
                append-icon=""
                clearable
                autofocus
                >
            </v-select> --}}
            <v-btn v-show="!dataset.searchform.model" icon v-tooltip:left="{'html': dataset.searchform.model ? 'Clear' : 'Search resources'}" @click.native="dataset.searchform.model = !dataset.searchform.model;dataset,searchform.query = '';"><v-icon>search</v-icon></v-btn>
        </template>
        {{-- /Search --}}

        <v-btn
            flat
            icon
            href="{{ route('courses.create') }}"
            v-tooltip:left="{'html': '{{ __('Add new course') }}'}"
        ><v-icon>add</v-icon></v-btn>

        {{-- <v-btn icon v-tooltip:left="{ html: 'Filter' }">
            <v-icon class="subheading">fa fa-filter</v-icon>
        </v-btn> --}}

        {{-- Batch Commands --}}
        <v-btn
            v-show="dataset.selected.length < 2"
            flat
            icon
            v-model="bulk.destroy.model"
            :class="bulk.destroy.model ? 'btn--active primary primary--text' : ''"
            v-tooltip:left="{'html': '{{ __('Toggle the bulk command checkboxes') }}'}"
            @click.native="bulk.destroy.model = !bulk.destroy.model"
        ><v-icon>@{{ bulk.destroy.model ? 'check_circle' : 'check_circle' }}</v-icon></v-btn>

        {{-- Bulk Delete --}}
        <v-slide-y-transition>
            <template v-if="dataset.selected.length > 1">
                <form action="{{ route('courses.destroy', 'false') }}" method="POST" class="inline">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <template v-for="item in dataset.selected">
                        <input type="hidden" name="id[]" :value="item.id">
                    </template>
                    <v-btn
                        flat
                        icon
                        type="submit"
                        v-tooltip:left="{'html': `Move ${dataset.selected.length} selected items to Trash`}"
                    ><v-icon warning>delete_sweep</v-icon></v-btn>
                </form>
            </template>
        </v-slide-y-transition>
        {{-- /Bulk Delete --}}
        {{-- /Batch Commands --}}

        {{-- Trashed --}}
        <v-btn
            icon
            flat
            href="{{ route('courses.trashed') }}"
            dark
            v-tooltip:left="{'html': `View trashed items`}"
        ><v-icon class="warning--after">archive</v-icon></v-btn>
        {{-- /Trashed --}}
    </v-toolbar>

    <v-container fluid grid-list-lg>
        <v-layout row wrap>
            <v-flex sm12>

                @include("Theme::partials.banner")

                <v-card class="mb-3 elevation-1">

                    <v-data-table
                        :loading="dataset.loading"
                        :total-items="dataset.totalItems"
                        class="elevation-0"
                        no-data-text="{{ _('No resource found') }}"
                        v-bind="bulk.destroy.model?{'select-all':'primary'}:[]"
                        {{-- selected-key="id" --}}
                        v-bind:headers="dataset.headers"
                        v-bind:items="dataset.items"
                        v-bind:pagination.sync="dataset.pagination"
                        v-model="dataset.selected">
                        <template slot="headerCell" scope="props">
                            <span v-tooltip:bottom="{'html': props.header.text}">
                                @{{ props.header.text }}
                            </span>
                        </template>
                        <template slot="items" scope="prop">
                            <td v-show="bulk.destroy.model"><v-checkbox hide-details class="primary--text" v-model="prop.selected"></v-checkbox></td>
                            <td v-html="prop.item.id"></td>
                            <td>
                                <v-avatar size="40px">
                                    <img class="ma-1" v-if="prop.item.feature" :src="prop.item.feature" :alt="prop.item.name">
                                </v-avatar>
                            </td>
                            <td><a :href="route(urls.show, (prop.item.id))" class="no-decoration td-n"><strong v-html="prop.item.title"></strong></a></td>
                            <td v-html="prop.item.code"></td>
                            <td><a :href="`{{ route('courses.index') }}?user_id=${prop.item.user_id}`" class="td-n black--text" v-html="prop.item.user.fullname"></a></td>
                            <td><v-chip v-if="prop.item.enrolled" small class="ml-0 green white--text">{{ __('Enrolled') }}</v-chip></td>
                            <td><span v-if="prop.item.category"><v-icon left class="body-2" v-html="prop.item.category.icon"></v-icon><a :href="`{{ route('courses.index') }}?category_id=${prop.item.category_id}`" class="td-n black--text"><span v-html="prop.item.category.name"></span></span></a></td>
                            <td v-html="prop.item.created"></td>
                            <td v-html="prop.item.modified"></td>
                            <td class="text-xs-center">
                                <v-menu bottom left>
                                    <v-btn icon flat slot="activator"><v-icon>more_vert</v-icon></v-btn>
                                    <v-list>
                                        <v-list-tile :href="route(urls.show, prop.item.slug)">
                                            <v-list-tile-action>
                                                <v-icon info>search</v-icon>
                                            </v-list-tile-action>
                                            <v-list-tile-content>
                                                <v-list-tile-title>
                                                    {{ __('View details') }}
                                                </v-list-tile-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                        <v-list-tile :href="route(urls.edit, (prop.item.id))">
                                            <v-list-tile-action>
                                                <v-icon accent>edit</v-icon>
                                            </v-list-tile-action>
                                            <v-list-tile-content>
                                                <v-list-tile-title>
                                                    {{ __('Edit') }}
                                                </v-list-tile-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                        <v-list-tile ripple @click="$refs[`destroy_${prop.item.id}`].submit()">
                                            <v-list-tile-action>
                                                <v-icon warning>delete</v-icon>
                                            </v-list-tile-action>
                                            <v-list-tile-content>
                                                <v-list-tile-title>
                                                    <form :id="`destroy_${prop.item.id}`" :ref="`destroy_${prop.item.id}`" :action="route(urls.destroy, prop.item.id)" method="POST">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}
                                                        {{ __('Move to Trash') }}
                                                        {{-- <v-btn type="submit">{{ __('Move to Trash') }}</v-btn> --}}
                                                    </form>
                                                </v-list-tile-title>
                                            </v-list-tile-content>
                                        </v-list-tile>
                                    </v-list>
                                </v-menu>
                            </td>
                        </template>
                    </v-data-table>
                </v-card>
                @if (request()->all())
                    {{-- <p class="caption grey--text"><a href="{{ route('courses.index') }}">{{ __('Remove filters') }}</a></p> --}}
                    <v-card-actions class="pa-0">
                        <v-btn error class="elevation-1 mx-0" href="{{ route('courses.index') }}">
                            <v-icon left>delete</v-icon>Remove Filter</v-btn>
                    </v-card-actions>
                @endif
            </v-flex>
        </v-layout>
    </v-container>
@endsection

@push('pre-scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/vue-resource/1.3.4/vue-resource.min.js"></script>
    <script>
        Vue.use(VueResource);

        mixins.push({
            data () {
                return {
                    bulk: {
                        destroy: {
                            model: false,
                        },
                    },
                    urls: {
                        edit: '{{ route('courses.edit', 'null') }}',
                        show: '{{ route('courses.show', 'null') }}',
                        destroy: '{{ route('courses.destroy', 'null') }}',
                    },
                    dataset: {
                        headers: [
                            { text: '{{ __("ID") }}', align: 'left', value: 'id' },
                            { text: '{{ __("Feature") }}', align: 'left', value: 'feature' },
                            { text: '{{ __("Title") }}', align: 'left', value: 'title' },
                            { text: '{{ __("Code") }}', align: 'left', value: 'code' },
                            { text: '{{ __("Author") }}', align: 'left', value: 'user_id' },
                            { text: '{{ __("Status") }}', align: 'left', value: 'enrolled' },
                            { text: '{{ __("Category") }}', align: 'left', value: 'category_at' },
                            { text: '{{ __("Created") }}', align: 'left', value: 'created_at' },
                            { text: '{{ __("Modified") }}', align: 'left', value: 'modified_at' },
                            { text: '{{ __("Actions") }}', align: 'center', sortable: false },
                        ],
                        items: [],
                        loading: true,
                        pagination: {
                            rowsPerPage: {{ settings('items_per_page', 15) }},
                            totalItems: 0,
                        },
                        searchform: {
                            model: false,
                            query: '',
                        },
                        selected: [],
                        totalItems: 0,
                    },
                };
            },

            watch: {
                'dataset.pagination': {
                    handler () {
                        this.get();
                    },
                    deep: true
                },

                'dataset.searchform.query': function (filter) {
                    setTimeout(() => {
                        const { sortBy, descending, course, rowsPerPage } = this.dataset.pagination;

                        let query = {
                            descending: descending,
                            course: course,
                            search: filter,
                            sort: sortBy,
                            take: rowsPerPage,
                        };

                        this.api().search('{{ route('api.courses.all') }}', query)
                            .then((data) => {
                                this.dataset.items = data.items.data ? data.items.data : data.items;
                                this.dataset.totalItems = data.items.total ? data.items.total : data.total;
                                this.dataset.loading = false;
                            });
                    }, 1000);
                },
            },

            methods: {
                get () {
                    const { sortBy, descending, course, rowsPerPage } = this.dataset.pagination;
                    let query = {
                        descending: descending,
                        course: course,
                        sort: sortBy,
                        take: rowsPerPage,
                        search: {!! @json_encode(request()->all()) !!},
                    };
                    this.api().get('{{ route('api.courses.all') }}', query)
                        .then((data) => {
                            this.dataset.items = data.items.data ? data.items.data : data.items;
                            this.dataset.totalItems = data.items.total ? data.items.total : data.total;
                            this.dataset.loading = false;
                        });
                },
            },
        });
    </script>

@endpush
