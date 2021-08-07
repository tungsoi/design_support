<script src="{{ asset('assets/furn/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('assets/furn/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/furn/fullPage/fullpage.js') }}"></script>
<script src="{{ asset('assets/furn/fullPage/vendors/scrolloverflow.min.js') }}"></script>


<script type="text/javascript">
    $(document).ready(function() {
        $('#fullpage').fullpage({
            sectionsColor: ['white', 'white', 'white', 'white', 'black'],
            navigation: true,
            responsiveWidth: 758,
            scrollOverflow: true,
            fitToSection: true
        });
    });
</script>


<script>
    $(document).on('click', '.category-link', function () {
        window.location.href = $(this).data('link');
    })
</script>

<script>
    $(document).on('click', '.dropdown-toggle', function (e) {
        let nextEl = this.nextElementSibling;
        if(nextEl && nextEl.classList.contains('submenu')) {
            console.log(nextEl);
            // prevent opening link if link needs to open dropdown
            e.preventDefault();
            if(nextEl.style.display == 'block'){
                nextEl.style.display = 'none';
            } else {
                nextEl.style.display = 'block';
            }

        }
    });
</script>
