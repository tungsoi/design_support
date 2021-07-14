<script src="{{ asset('assets/furn/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/furn/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/furn/fullPage/fullpage.js') }}"></script>
<script src="{{ asset('assets/furn/fullPage/vendors/scrolloverflow.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#fullpage').fullpage({
            sectionsColor: ['black', 'white', 'white', 'white', 'black'],
            navigation: true,
            responsiveWidth: 758,
            scrollOverflow: true,
            fitToSection: true
        });
    });
</script>
