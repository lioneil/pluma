{{-- Inline template --}}
<script type="text/x-template" id="template-draggable">
    <draggable :move="moved" @change="move" :list="items" :options="options" class="sortable-container">
        <div :key="i" v-for="(t,i) in items" class="mb-3 draggable" :class="{'sortable-handle': (t.new?t.new:false)}">
            <v-card tile class="elevation-1" :class="{'accent white--text': t.new}">
                <v-card-text>
                    <input type="hidden" name="parent_id" :value="t.parent_id">
                    <strong class="subheading" v-html="`${t.title}`"></strong>
                    <div class="caption"><span v-html="`{{ __('Parent:') }} ${t.parent_name}`"></span></div>
                    <div class="caption">{{ url('/') }}/<span v-html="t.slug"></span></div>
                </v-card-text>
            </v-card>
            <div class="bordered--ant ml-4">
                {{-- <span v-html="t.children"></span> --}}
                <local-draggable @changed="changed" :items="t.children" :options="options"></local-draggable>
            </div>
        </div>
    </draggable>
</script>

<local-draggable @changed="changed" :items="items" :options="options"></local-draggable>

@push('css')
    <style>
        .sortable-container {
            min-height: 20px !important;
        }

        .bordered--ant {
            border-left: 1px dashed rgba(0,0,0, 0.2) !important;
            border-bottom: 1px dashed rgba(0,0,0, 0.2) !important;
        }
    </style>
@endpush

@push('pre-scripts')
    <script src="{{ assets('frontier/vendors/vue/draggable/sortable.min.js') }}"></script>
    <script src="{{ assets('frontier/vendors/vue/draggable/draggable.min.js') }}"></script>
    <script>
        let localDraggable = {
            name: 'local-draggable',
            model: {prop: 'items'},
            template: '#template-draggable',
            props: ['items', 'options'],
            methods: {
                moved (evt) {
                    if (! evt.draggedContext.element.new) {
                        return false;
                    }
                },
                changed (items, evt) {
                    this.$emit('changed', this.items, evt);
                    this.$emit('input', this.items);
                },
                move (evt, origEvt) {
                    this.$emit('changed', this.items, evt);
                    this.$emit('input', this.items);
                },
            }
        }

        mixins.push({
            components: {'local-draggable': localDraggable},
            data () {
                return {
                    options: {
                        animation: 150,
                        draggable: '.draggable',
                        group: {name: 'pages'},
                        forceFallback: true,
                    },
                    items: [],
                }
            },
            methods: {
                update (items, parent) {
                    let branch = [];

                    items = items ? items : this.items;
                    parent = parent ? parent : {id: null, title: 'root', slug: ''};

                    for (var i = 0; i < items.length; i++) {
                        let current = items[i];
                        if (current.children) {
                            current.children = this.update(current.children, {id: current.id, title: current.title, slug: current.slug});
                        }

                        current.parent_id = parent.id;
                        current.parent_name = parent.title;
                        current.slug = parent.slug + (parent.slug?'/':'') + current.code;

                        branch.push(current);
                    }

                    return branch;
                },
                changed (items, evt) {
                    this.items = this.update(items);
                },
            },
            mounted () {
                let items = [this.resource].concat({!! json_encode($items) !!});
                this.items = this.update(items);
            }
        });
    </script>
@endpush
