  @include('Theme::partials.footer')

  @stack('before:js')

  @section('js')
    <!-- section js -->
    <script src="{{ theme('dist/vendor.min.js') }}?v={{ app()->environment() === 'development' ? date('his') : $application->version }}"></script>
    <script src="{{ theme('dist/app.min.js') }}?v={{ app()->environment() === 'development' ? date('his') : $application->version }}"></script>
    <!-- section js -->
  @show

  @stack('after:js')
</body>
</html>
