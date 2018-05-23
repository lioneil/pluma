<v-toolbar :dark="theme.dark" flat app scroll-off-screen transition="slide-y-transition">
  <v-toolbar-side-icon @click="localstorage({'single.sidebar.model': (sidebar.model = !sidebar.model)})"></v-toolbar-side-icon>
  <v-text-field flat solo :dark="theme.dark" placeholder="Search"></v-text-field>
  <v-spacer></v-spacer>
  <v-btn icon ripple @click="rightsidebar.model = !rightsidebar.model"><v-icon color="grey">keyboard_arrow_left</v-icon></v-btn>
</v-toolbar>
