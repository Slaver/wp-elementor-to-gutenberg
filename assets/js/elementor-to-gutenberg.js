jQuery(document).ready(function($) {
    let totalPosts = 0, convertedPosts = 0, submitForm = $('#e2g')

    $('form', submitForm).on('submit', function(e) {
        e.preventDefault()

        let debug = $('input[name=debug]', submitForm).is(':checked')

        if (confirm('Are you sure to run convertation?')) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'run_convert'
                },
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('[type=submit]', submitForm).attr('disabled', 'disabled')
                    $('[type=checkbox]', submitForm).attr('disabled', 'disabled')
                    $('.debug-data', submitForm).html('')
                    $('.debug', submitForm).hide()
                    if (!debug) {
                        $('.convert-data', submitForm).show()
                        $('.progress-bar', submitForm).show()
                    }
                },
                success: function (response) {
                    if (response.success) {
                        totalPosts = response.data.count
                        next(debug)
                    }
                }
            })
        }
    })

    function next(debug = false) {
        $.ajax({
            url: ajaxurl,
            type: 'POST',
            data: {
                'action': 'next_convert',
                'debug': debug
            },
            dataType: 'json',
            cache: false,
            error: function () {
                $('.debug', submitForm).show()
                $('.debug-data', submitForm).append('<div class="text-error"><p>'+response.data+'</p></div>')
                restore()
            },
            success: function (response) {
                $('.debug', submitForm).show()
                if (response.success) {
                    if (debug) {
                        $.each(response.data, function (i, obj) {
                            $('.debug-data', submitForm)
                                .append('<h2><a href="/wp-admin/post.php?post=' + obj.post.ID + '&action=edit">' + obj.post.post_title + '</a></h2>')
                                .append(document.createTextNode(obj.converted))
                        })
                    } else {
                        $.each(response.data, function (i, obj) {
                            convertedPosts++
                            $('.convert-data ul', submitForm)
                                .append('<li><span><strong>#' + obj.post.ID + '</strong></span> ' +
                                    '<span><a href="/wp-admin/post.php?post=' + obj.post.ID + '&action=edit">edit</a></span>' +
                                    '<a href="/?p=' + obj.post.ID + '">' + obj.post.post_title + '</a></li>')

                            $('.progress-bar span', submitForm).css('width', (convertedPosts / totalPosts * 100) + '%')
                        })
                    }
                } else {
                    $('.debug-data', submitForm).append('<div class="text-error"><p>'+response.data+'</p></div>')
                }

                if (!debug && (totalPosts - convertedPosts) > 0) {
                    next()
                } else {
                    restore()
                }
            }
        })
    }

    function restore() {
        $('[type=submit]', submitForm).removeAttr('disabled')
        $('[type=checkbox]', submitForm).removeAttr('disabled')
        $('.progress-bar', submitForm).hide()
    }
})