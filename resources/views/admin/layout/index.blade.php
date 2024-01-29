<!DOCTYPE html>
<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="{{ asset('admin-frontend') }}/assets/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <title> @yield('title')</title>
    <meta name="description" content="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('admin-frontend') }}/assets/img/favicon/favicon.ico" />
    <link rel="apple-touch-icon" sizes="180x180"
        href="{{ asset('admin-frontend') }}/assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32"
        href="{{ asset('admin-frontend') }}/assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16"
        href="{{ asset('admin-frontend') }}/assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="{{ asset('admin-frontend') }}/assets/img/favicon/site.webmanifest">
    {{-- Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&display=swap"
        rel="stylesheet" />

    {{-- Icons --}}
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/fonts/boxicons.css" />
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/fonts/fontawesome.css" />
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/fonts/flag-icons.css" />

    {{-- Core CSS --}}
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/css/rtl/core.css"
        class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/css/rtl/theme-default.css"
        class="template-customizer-theme-css" />
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/css/demo.css" />

    {{-- Vendors CSS --}}
    <link rel="stylesheet"
        href="{{ asset('admin-frontend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css" />
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/typeahead-js/typeahead.css" />
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/apex-charts/apex-charts.css" />
    <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/@form-validation/umd/styles/index.min.css" />

  <link rel="stylesheet"
    href="{{ asset('admin-frontend') }}/assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css" />
  <link rel="stylesheet"
    href="{{ asset('admin-frontend') }}/assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css" />
  <link rel="stylesheet"
    href="{{ asset('admin-frontend') }}/assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css" />
  <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/select2/select2.css" />
  <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/animate-css/animate.css" />
  <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/sweetalert2/sweetalert2.css" />
  <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/dropzone/dropzone.css" />
  <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/libs/tagify/tagify.css" />
  <link rel="stylesheet"
    href="{{ asset('admin-frontend') }}/assets/vendor/libs/bootstrap-select/bootstrap-select.css" />
  {{-- Page CSS --}}
  <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/css/pages/page-auth.css" />
  <link rel="stylesheet" href="{{ asset('admin-frontend') }}/assets/vendor/css/pages/page-profile.css" />
  {{-- Helpers --}}
  <script src="{{ asset('admin-frontend') }}/assets/vendor/js/helpers.js"></script>
  {{-- ! Template customizer & Theme config files MUST be included after core stylesheets and helpers.js in the --}}
  {{--

  <head> section --}}
    {{-- ? Template customizer: To hide customizer set displayCustomizer value false in config.js. --}}
    <script src="{{ asset('admin-frontend') }}/assets/vendor/js/template-customizer.js"></script>
    {{-- ? Config: Mandatory theme config file contain global vars & default theme options, Set your preferred theme
    --}}
    {{-- option in this file. --}}
    <script src="{{ asset('admin-frontend') }}/assets/js/config.js"></script>

    {{-- import here --}}
    <script src="https://cdn.tiny.cloud/1/{{ getEnv('TinyMCE_KEY') }}/tinymce/6/tinymce.min.js" referrerpolicy="origin">
    </script>
  </head>

<body>
  @php
  $layout = $layout ?? "main";
  @endphp
  @if ($layout == 'main')
  {{-- Layout wrapper --}}
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">
      {{-- Menu --}}
      @include('admin.layout.aside')

      {{-- / Menu --}}

      {{-- Layout container --}}
      <div class="layout-page">
        {{-- Navbar --}}
        @include('admin.layout.navbar')

        {{-- / Navbar --}}

        {{-- Content wrapper --}}
        <div class="content-wrapper">
          {{-- Content --}}
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content')
          </div>
          {{-- / Content --}}

          {{-- Footer --}}
          @include('admin.layout.footer')
          {{-- / Footer --}}

          <div class="content-backdrop fade"></div>
        </div>
        {{-- Content wrapper --}}
      </div>
      {{-- / Layout page --}}
    </div>
    {{-- Overlay --}}
    <div class="layout-overlay layout-menu-toggle"></div>

    {{-- Drag Target Area To SlideIn Menu On Small Screens --}}
    <div class="drag-target"></div>
  </div>
  {{-- / Layout wrapper --}}
  @else
  {{-- Layout wrapper authentication --}}
  <div class="authentication-wrapper authentication-cover">
    @yield('content')
  </div>
  {{-- Layout wrapper authentication --}} @endif



  {{-- Core JS --}}
  {{-- build:js assets/vendor/js/core.js --}}

  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/jquery/jquery.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/popper/popper.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/js/bootstrap.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/hammer/hammer.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/i18n/i18n.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/typeahead-js/typeahead.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/js/menu.js"></script>

  {{-- endbuild --}}

  {{-- Vendors JS --}}
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/apex-charts/apexcharts.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/@form-validation/umd/bundle/popular.min.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js">
  </script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js">
  </script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/moment/moment.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/select2/select2.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/cleavejs/cleave.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/cleavejs/cleave-phone.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/sweetalert2/sweetalert2.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/tagify/tagify.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/bloodhound/bloodhound.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/vendor/libs/dropzone/dropzone.js"></script>
  {{-- Main JS --}}
  <script src="{{ asset('admin-frontend') }}/assets/js/main.js"></script>

  {{-- Page JS --}}
  <script src="{{ asset('admin-frontend') }}/assets/js/dashboards-analytics.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/js/pages-auth.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/js/forms-selects.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/js/forms-tagify.js"></script>
  <script src="{{ asset('admin-frontend') }}/assets/js/forms-typeahead.js"></script>
  {{-- import here --}}
  @yield('script')

</body>

</html>
