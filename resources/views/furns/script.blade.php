<script src="{{ asset('assets/furn/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/furn/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/furn/fullPage/fullpage.js') }}"></script>
<script src="{{ asset('assets/furn/fullPage/vendors/scrolloverflow.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#fullpage').fullpage({
            sectionsColor: ['black', 'white', 'white', 'white'],
            navigation: true,
            responsiveWidth: 758,
            scrollOverflow: true
        });

        // if ($(window).width() < 1024) {
        //     $('#fullpage').removeAttr('id');
        // }
    });
</script>
