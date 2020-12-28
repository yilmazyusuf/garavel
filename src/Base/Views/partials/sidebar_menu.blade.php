@push('scripts')
    <script>
        $(document).ready(function () {
            $('a.active').each(
                function (e) {
                    var parent = $(this).closest('li.has-treeview');
                    $(parent).addClass('menu-open');
                }
            );
        });
    </script>
@endpush
{!! $menus !!}
