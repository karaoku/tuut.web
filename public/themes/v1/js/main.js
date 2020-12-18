$(document).ready(function() {
    $('.addLike').click(function() {
        alert("addlike");
        let user_id = $(this).attr("user-id");
        let tuut_id = $(this).attr("tuut-id");
        let pathname = "app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" tuut-id=\""+tuut_id+"\" class=\"rating-icon rating-icon-up removeLike\"><i class=\"fas fa-minus\"></i></div>");
        var data = {
            process : "addLike",
            user_id : user_id,
            tuut_id : tuut_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    $('.removeLike').click(function() {
        alert("removelike");
        let user_id = $(this).attr("user-id");
        let tuut_id = $(this).attr("tuut-id");
        let pathname = "app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" tuut-id=\""+tuut_id+"\" class=\"rating-icon rating-icon-up addLike\"><i class=\"fas fa-chevron-up\"></i></div>");
        var data = {
            process : "removeLike",
            user_id : user_id,
            tuut_id : tuut_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    $('.addUnlike').click(function() {
        alert("add_unlike");
        let user_id = $(this).attr("user-id");
        let tuut_id = $(this).attr("tuut-id");
        let pathname = "app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" tuut-id=\""+tuut_id+"\" class=\"rating-icon rating-icon-down addUnlike\"><i class=\"fas fa-minus\"></i></div>");
        var data = {
            process : "addUnlike",
            user_id : user_id,
            tuut_id : tuut_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    $('.removeUnlike').click(function() {
        alert("remove_unlike");
        let user_id = $(this).attr("user-id");
        let tuut_id = $(this).attr("tuut-id");
        let pathname = "app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" tuut-id=\""+tuut_id+"\" class=\"rating-icon rating-icon-down removeUnlike\"><i class=\"fas fa-chevron-down\"></i></div>");
        var data = {
            process : "removeUnlike",
            user_id : user_id,
            tuut_id : tuut_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    $('.comment_addLike').click(function() {
        alert("comment_addlike");
        let user_id = $(this).attr("user-id");
        let comment_id = $(this).attr("comment-id");
        let pathname = "../app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" comment-id=\""+comment_id+"\" class=\"tuut-post-comment-rating-icon comment_removeLike\"><i class=\"fas fa-chevron-up\" style=\"color: #5e5e5e\"></i></div>");
        var data = {
            process2 : "comment_addLike",
            user_id : user_id,
            comment_id : comment_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    $('.comment_removeLike').click(function() {
        alert("comment_removelike");
        let user_id = $(this).attr("user-id");
        let comment_id = $(this).attr("comment-id");
        let pathname = "../app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" comment-id=\""+comment_id+"\" class=\"tuut-post-comment-rating-icon comment_addLike\"><i class=\"fas fa-chevron-up\"></i></div>");
        var data = {
            process2 : "comment_removeLike",
            user_id : user_id,
            comment_id : comment_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    $('.comment_addUnlike').click(function() {
        alert("comment_add_unlike");
        let user_id = $(this).attr("user-id");
        let comment_id = $(this).attr("comment-id");
        let pathname = "../app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" comment-id=\""+comment_id+"\" class=\"tuut-post-comment-rating-icon comment_addUnlike\"><i class=\"fas fa-chevron-down\" style=\"color: #5e5e5e\"></i></div>");
        var data = {
            process2 : "comment_addUnlike",
            user_id : user_id,
            comment_id : comment_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    $('.comment_removeUnlike').click(function() {
        alert("comment_remove_unlike");
        let user_id = $(this).attr("user-id");
        let comment_id = $(this).attr("comment-id");
        let pathname = "../app/process.php";
        $(this).replaceWith("<div user-id=\""+user_id+"\" comment-id=\""+comment_id+"\" class=\"tuut-post-comment-rating-icon comment_removeUnlike\"><i class=\"fas fa-chevron-down\"></i></div>");
        var data = {
            process2 : "comment_removeUnlike",
            user_id : user_id,
            comment_id : comment_id,
        };
        $.post(pathname, data, function (alert) {
            console.log(alert)
        });
    });

    (function ($) {
        $.fn.clickToggle = function (func1, func2) {
            var funcs = [func1, func2];
            this.data('toggleclicked', 0);
            this.click(function () {
                var data = $(this).data();
                var tc = data.toggleclicked;
                $.proxy(funcs[tc], this)();
                data.toggleclicked = (tc + 1) % 2;
            });
            return this;
        };
    }(jQuery));

    $('.dropdown-item').clickToggle(function () {
        $(this).parents('.tuut-dropdown').find('.tuut-dropdown-menu').show();
    }, function () {
        $(this).parents('.tuut-dropdown').find('.tuut-dropdown-menu').hide();
    });

});