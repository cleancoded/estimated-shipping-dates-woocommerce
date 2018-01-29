(function ($) {
    $(document).ready(function () {
        $(".single_variation_wrap").on("show_variation", function (event, variation) {
            $(".date_for_variation").hide();
            if ($(".date_variation_" + variation.variation_id).length > 0) {
                $(".date_variation_" + variation.variation_id).show();
            }
        });
    });
})(jQuery);

