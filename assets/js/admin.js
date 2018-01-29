(function ($) {
    $(document).ready(function () {
        $(".rpesp_adddayrow").click(function () {
            $("#rpesp_tblinitrow").find(".rpesp_initrow").clone().insertAfter('#th_rpesp_specific_day');
            $(".rpesp_removedayrow").click(function () {
                $(this).parent().parent().remove();
            });
        });
        $(".rpesp_removedayrow").click(function () {
            $(this).parent().parent().remove();
        });
        $(".rpesp_addperiodrow").click(function () {
            $("#rpesp_tblinitperiodrow").find(".rpesp_thinitperiodrow").clone().insertAfter('#th_rpesp_specific_period_day');
            $(".rpesp_removeperiodrow").click(function () {
                $(this).parent().parent().remove();
            });
        });
        $(".rpesp_removeperiodrow").click(function () {
            $(this).parent().parent().remove();
        });
        $('.txtcolor').wpColorPicker();

        $('#the-list').on('click', '.editinline', function () {
            inlineEditPost.revert();
            var $post_id = $(this).closest('tr').attr('id');
            $post_id = $post_id.replace('post-', '');
            var $wcan_inline_data = $('#rpwoo_product_delivery_inline_' + $post_id);
            $('input[name="est_delivery_time"]', '.inline-quick-edit').val($wcan_inline_data.find('._delivery_esttime').html());
            $('input[name="est_delivery_text"]', '.inline-quick-edit').val($wcan_inline_data.find('._delivery_esttext').html());
            if ($wcan_inline_data.find('._delivery_enable').html() == '1') {
                $('input[name="enable_delivery_date"]', '.inline-quick-edit').attr("checked", true);
            }
            if ($wcan_inline_data.find('._delivery_enable_for_variation').html() == '1') {
                $('input[name="enable_delivery_date_variation"]', '.inline-quick-edit').attr("checked", true);
            }

        });
    });
})(jQuery);