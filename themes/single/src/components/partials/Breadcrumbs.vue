<template>
  <v-breadcrumbs>
    <v-icon slot="divider">keyboard_arrow_right</v-icon>
    <v-breadcrumbs-item
      :disable="breadcrumb.disabled"
      :to="breadcrumb.slug"
      :key="i"
      exact
      v-for="(breadcrumb, i) in breadcrumbs"
    >
      <small v-html="breadcrumb.label"></small>
    </v-breadcrumbs-item>
  </v-breadcrumbs>
</template>

<script>
export default {
  name: 'Breadcrumbs',
  props: {
    url: ''
  },
  data () {
    return {
      breadcrumbs: []
    }
  },
  methods: {
    get () {
      this.$http.post(this.url, {path: this.$route.fullPath, routename: this.$route.name})
        .then(response => {
          this.breadcrumbs = response.data
        })
    }
  },
  watch: {
    '$route': function (route) {
      this.get()
    }
  },
  mounted () {
    this.get()
  }
}
</script>
