$(document).ready(function() {
    $('.question').on('click', function(event) {
        event.preventDefault();

        $(this).css('font-weight', '700');

        var $parent = $(this).parent();
        var $answer = $parent.find('.answer');

        // Check if the answer is currently visible
        if ($answer.is(':visible')) {
            // Animate the hiding of the answer
            $answer.slideUp(300); // 1000ms = 1 second
            $(this).css('font-weight', '400');
        } else {
            // Animate the showing of the answer
            $answer.slideDown(300); // 1000ms = 1 second
        }

        $parent.toggleClass('active');
    });
});
