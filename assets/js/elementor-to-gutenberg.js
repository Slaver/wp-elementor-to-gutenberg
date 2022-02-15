jQuery(document).ready(function($) {
    let totalPosts = 0, convertedPosts = 0, workDiv = $('#e2g')

    $('form', workDiv).on('submit', function(e) {
        e.preventDefault()

        let debug = $('input[name=debug]', workDiv).is(':checked')

        if (confirm('Are you sure to run conversion?')) {
            $.ajax({
                url: ajaxurl,
                type: 'POST',
                data: {
                    'action': 'run_convert'
                },
                dataType: 'json',
                cache: false,
                beforeSend: function() {
                    $('[type=submit]', workDiv).attr('disabled', 'disabled')
                    $('[type=checkbox]', workDiv).attr('disabled', 'disabled')
                    $('.debug-data', workDiv).html('')
                    $('.debug', workDiv).hide()
                    if (!debug) {
                        $('.convert-data', workDiv).show()
                        $('.progress-bar', workDiv).show()
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
            error: function (response) {
                console.log(response.responseText)
                $('.debug', workDiv).show()
                $('.convert-data', workDiv).hide()
                if (response.data) {
                    $('.debug-data', workDiv).append('<div class="text-error"><p>' + response.data + '</p></div>')
                } else {
                    $('.debug-data', workDiv).append(response.responseText)
                }
                restore()
            },
            success: function (response) {
                $('.debug', workDiv).show()
                if (response.success) {
                    if (debug) {
                        $.each(response.data, function (i, obj) {
                            $('.debug-data', workDiv)
                                .append('<h2><a href="/wp-admin/post.php?post=' + i + '&action=edit">' + obj.title + '</a></h2>')
                                .append(document.createTextNode(obj.converted))
                        })
                    } else {
                        $.each(response.data, function (i, obj) {
                            convertedPosts++
                            $('.convert-data ul', workDiv)
                                .prepend('<li><span><strong>#' + i + '</strong></span> ' +
                                    '<span><a href="/wp-admin/post.php?post=' + i + '&action=edit">edit</a></span>' +
                                    '<a href="/?p=' + i + '">' + obj.title + '</a></li>')

                            $('.progress-bar span', workDiv).css('width', (convertedPosts / totalPosts * 100) + '%')
                        })
                    }

                    if (!debug && (totalPosts - convertedPosts) > 0) {
                        next()
                    } else {
                        restore()
                    }
                } else {
                    if (response.data) {
                        $('.debug-data', workDiv).append('<div class="text-error"><p>' + response.data + '</p></div>')
                    }
                    restore()
                }
            }
        })
    }

    function restore() {
        $('[type=submit]', workDiv).removeAttr('disabled')
        $('[type=checkbox]', workDiv).removeAttr('disabled')
        $('.progress-bar', workDiv).hide()
    }
})