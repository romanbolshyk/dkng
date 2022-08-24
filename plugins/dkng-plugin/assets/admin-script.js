(function ($) {


    /**
     * Function makes the equal height for row in case when one of td element have > height than others
     */
    function tableRowsHeight() {
        const tables = document.querySelectorAll('.js-table-height');

        tables.forEach(function (table) {
            setHeight(table);
        });

        function setHeight(table) {
            const rows = table.querySelectorAll('tr');

            for(let row of rows) {
                let height = 0;
                const content = row.querySelectorAll('div');

                content.forEach(function (item) {
                    item.style.minHeight = 0;
                });

                for(let item of content) {
                    height = item.offsetHeight > height ? item.offsetHeight : height;
                }

                content.forEach(function (item) {
                    item.style.minHeight = height + 'px';
                });
            }
        }
    }


    $(document).ready(function () {

        if($.fn.datePicker instanceof Object) {
            $('.js-datePicker').datePicker();
            $('.js-sending-date-edit').datePicker();
        }
    });

    $(window).on('resize orientationchange', function () {
        tableRowsHeight();
        setTimeout(campaignsFieldsEqualHeight, 0);
    });

    $(window).on('load', tableRowsHeight);

})(jQuery);
