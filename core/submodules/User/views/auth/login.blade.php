@extends("Theme::layouts.auth")

@section("main")
  {{-- @parent --}}
  <v-jumbotron :gradient="`to top right, #022242 10%, #420224 100%`" height="100%">
    <v-container fluid fill-height>
      <v-layout row wrap justify-center align-center>
        <v-flex lg3 md4 sm8 xs12 justify-center align-center>

          <v-slide-y-transition mode="in-out">
            <login-card
              color="primary"
              class="pa-3"
              logo="{{ $application->site->logo }}"
              subtitle="{{ $application->site->tagline }}"
              title="{{ $application->site->title }}"
            ></login-card>
          </v-slide-y-transition>

          <span class="white--text">@{{ route('pages.create') }}</span>

        </v-flex>
      </v-layout>
    </v-container>
  </v-jumbotron>
@endsection
