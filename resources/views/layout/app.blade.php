<!DOCTYPE html>
<html lang="en">

<head>

    @include('partials.head')

</head>

<body id="page-top" class="@yield('class')">

<!-- Page Wrapper -->
<div id="wrapper">

    @guest

    @else
    <!-- Sidebar -->
    @include('partials.navbar')
    <!-- End of Sidebar -->

    @endguest

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            @include('partials.topbar')
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            @yield('content')
            <!-- /.container-fluid -->

        </div>
        <!-- End of Main Content -->

        <!-- Footer -->
        @include('partials.footer')
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

    @include('partials.footer-script')

</body>

</html>