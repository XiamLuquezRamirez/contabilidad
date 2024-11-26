<!DOCTYPE html>
<html lang="en">
@if (auth()->check())
    @include('Plantilla.head')

    <body>
        @include('Plantilla.menu')
        <div id="right-panel" class="right-panel">

            @include('Plantilla.cabecera')


            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                <!-- Main content -->
                @yield('Contenido')
                </section>
                <!-- /.content -->

            </div>

            @include('Plantilla.footer')
            @yield('scripts')
        </div>
    @else
        <script>
              window.location.href = "{{ route('login') }}";
        </script>
@endif
</body>

</html>
