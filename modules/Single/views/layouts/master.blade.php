@include("Single::partials.header")

<v-app standalone>
    @include("Single::components.navigation-drawer")
    @include("Single::components.toolbar")
    <main>
        <v-container fluid>
            <v-layout align-center justify-center>
                <router-view></router-view>
            </v-layout>
        </v-container>
    </main>
    @include("Single::components.endnote")
</v-app>

<script>
    // var app = new Vue({
    //     el: 'v-app',
    //     data: {
    //         application: JSON.parse('{!! json_encode($application) !!}'),
    //         user: JSON.parse('{!! json_encode(auth()->user()) !!}'),
    //         sidebar: JSON.parse('{!! json_encode($navigation->sidebar->collect) !!}'),
    //         drawer: true,
    //         mini: false,
    //         theme: 'dark',
    //         dark: true,
    //         light: false,
    //     }
    // });
</script>

@include("Single::partials.footer")
