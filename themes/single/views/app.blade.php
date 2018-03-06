@include("Theme::partials.head")

@section("app")
  <div id=app data-root-application>
    <v-app>

      @stack("before-content")

      <v-content>

        @stack("before-inner-content")

        <v-slide-x-reverse-transition mode="out-in">
          <router-view :class="`font-size-${settings.fontsize}`"></router-view>
        </v-slide-x-reverse-transition>

        @stack("after-inner-content")

        @if (config('debugging.debug'))
          {{-- <v-card dark>
            <alert-icon small></alert-icon>
            <alert-icon mode="warning"></alert-icon>
          </v-card> --}}
          <v-btn color="success" @click="snackbar.color='secondary';snackbar.type='success';snackbar.theme='dark';snackbar.text='The Succession successfully succeeded!'; snackbar.model = !snackbar.model">Snackbar Success Test</v-btn>
          <v-btn color="warning" @click="snackbar.type='warning';snackbar.theme='dark';snackbar.text='Oops! Looks like something went wrong'; snackbar.model = !snackbar.model">Snackbar Warning Test</v-btn>
          <v-btn color="error" @click="snackbar.type='error';snackbar.theme='dark';snackbar.text='An error occurred!'; snackbar.model = !snackbar.model;snackbar.color='secondary'">Snackbar Error Test</v-btn>
          <v-btn color="info" @click="dialog.type='prompt';dialog.theme='dark';dialog.text='A prompt occurred!'; dialog.model = !dialog.model;dialog.color='secondary'">Dialog Question Test</v-btn>
          <v-dialog v-model="dialog.model" width="50%">
            <v-card flat :dark="theme.dark" :light="!theme.dark">
              <alert-icon medium mode="prompt"></alert-icon>
              <v-card-text class="grey--text">
                <p class="headline">Are you sure you want to reset the Application UI?</p>
                <p class="subheading">Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. A small river named Duden flows by their place and supplies it with the necessary regelialia.</p>
                <p class="error--text">This is your last warning.</p>
              </v-card-text>
              <v-card-actions>
                <v-spacer></v-spacer>
                <v-btn color=default @click="dialog.model = false">No</v-btn>
                <v-dialog ref="success-dialog" width="50%">
                  <v-btn slot=activator color=primary @click="dialog.model = false">Yes</v-btn>
                  <v-card flat :dark="theme.dark" :light="!theme.dark">
                    <alert-icon medium mode="success"></alert-icon>
                    <v-card-text class="text-xs-center">
                      <p class="headline">Success on whatever that action was!</p>
                    </v-card-text>
                    <v-card-actions>
                      <v-spacer></v-spacer>
                      {{-- <v-btn color=primary @click="$refs['success-dialog'].close()">Okay</v-btn> --}}
                    </v-card-actions>
                  </v-card>
                </v-dialog>
              </v-card-actions>
            </v-card>
          </v-dialog>
        @endif

      </v-content>

      @stack("after-content")

      @stack("debugger")

    </v-app>
  </div>
@show

@include("Theme::partials.foot")
