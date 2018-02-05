<!-- REQUIRED JS SCRIPTS -->

<!-- jQuery 2.1.4 -->
<script src="{{ asset('/plugins/jQuery/jQuery-2.1.4.min.js') }}"></script>

<!-- Sparkline Js for charts -->
<script src="{{ asset('/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
<script src="{{ asset('/plugins/knob/jquery.knob.js') }}"></script>

<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset('/js/bootstrap.min.js') }}" type="text/javascript"></script>
<!-- AdminLTE App -->
<script src="{{ asset('/js/app.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/demo.js') }}" type="text/javascript"></script>

<script src="{{ asset('/js/slimScroll/jquery.slimscroll.min.js') }}"></script>
<!-- <script src="{{ asset('/js/common/perfect-scrollbar.jquery.min.js') }}"></script> -->
<script src="{{ asset('/js/fastclick/fastclick.js') }}"></script>
<script src="{{ asset('/js/smoothscroll.js') }}"></script>


<script src="{{ asset('/js/initial_loading.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/common/script.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/common/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/common/function.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/common/datatable_function.js') }}" type="text/javascript"></script>

<!-- bootbox popup -->
<script src="{{ asset('/js/common/bootbox.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/common/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('/js/common/all_validation.js') }}" type="text/javascript"></script>

<!-- <script src="{{ asset('/js/common/socket.js') }}" type="text/javascript"></script> -->


<?php
    $js_data['env'] = env('APP_ENV');
    $js_data['errors'] = (isset($errors) && count($errors) > 0) ? $errors->toArray() : [];
    $js_data['user_id'] = isset(Auth::user()->emp_id) ? Auth::user()->emp_id : '';
?>
@yield('php-to-js')

<script type="text/javascript">
    var lang = lang || {};
    $.extend(true, lang, {!! json_encode($js_data) !!});
    errorDisplay();
</script>

<script src="{{ asset('/js/socket.io.js') }}"></script>
<script src="{{ asset('/js/notify.js') }}"></script>
<script>
    var url = window.location.hostname;
    console.log('url', url, lang.user_id)
    var socket = io('http://'+url+':3000');
    socket.on("test-channel:App\\Events\\BroadcastEvent", function(message){
        for (var k in message.data[0].notify_to) {
            // console.log(message.data[0].notify_to[k] , "in socket", lang.user_id)
            if(message.data[0].notify_to[k] == lang.user_id) {
                $.notify(message.data[0].notify_msg, "info");
                // bootbox.alert(message.data[0].notify_msg);
                //to increment the notification counter
                count = $('.notify-count').text();
                $('.notify-count').text((parseInt(count) + 1));
            }
        }
    });

    // code for notifications on the main header blade
    $(document).on('click', '.dropdown-toggle', function() {
        $('.notify-count').text(0);
        $.ajax({
            url : '/get-notifications',
            type : 'get',
            data : {
                'entity' : 'get_notifications'
            },
            success : function(res) {
                $('.menu').html('');
                for (var k in res) {
                    if(typeof res[k].actionable_flag === 'undefined' && res[k].actionable_flag != 1)
                    {
                        var i = $('<i />', {
                            class : 'fa fa-info-circle text-aqua',
                        });
                    } else {
                        var i = $('<i />', {
                            class : 'fa fa-pencil-square-o text-red',
                        });
                    } 
                    var a = $('<a />', {
                        href : res[k].url,
                        title : res[k].message
                    });
                    
                    var li = $('<li />').append($(a).append(i).append(res[k].message));
                    $('.menu').append(li);
                }
            },
            complete : function(res) {

            }
        })
    });

</script>


<!-- Optionally, you can add Slimscroll and FastClick plugins.
Both of these plugins are recommended to enhance the
user experience. Slimscroll is required when using the
fixed layout. -->

@yield('custom-scripts' )