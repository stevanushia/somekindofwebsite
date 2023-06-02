<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/js/adminlte.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1.0/dist/css/adminlte.min.css">

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/3.1.0/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

<!-- Chartist.js CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">


<!-- DATA TABLES -->
<script src="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script>
    new DataTable( '#myTable', {
        ordering: false
    } );
</script>

<!-- Chartist.js JS -->
<script src="https://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<link href="https://vjs.zencdn.net/7.14.3/video-js.css" rel="stylesheet" />
<script src="https://vjs.zencdn.net/7.14.3/video.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@videojs/http-streaming@3.3.0/dist/videojs-http-streaming.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
    $('.select2').select2({
        tags: true,
        tokenSeparators: [',', ' '],
        placeholder: 'Select or enter multiple values',
        allowClear: true
    });
    });

    $(document).ready(function() {
        $('.datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
        });
    });

    $(document).ready(function() {
        $('.select2').select2();
    }); 


    function showNotif() {
        Swal.fire({
            title: 'Update Success',
            icon: 'success',
            confirmButtonText: 'OK',
            reverseButtons: true
        }).then((result) => {
            console.log(result);
            if (result.isConfirmed) {
                console.log(document.getElementById('update1-form'));
                document.getElementById('update1-form').submit(); // Submit the form
            }
        });
        }

    function showConfirmation(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to revert this!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, submit it!',
            cancelButtonText: 'No, cancel!',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(id).submit(); 
            }
        });
        }

        $(function() {
            $("#sortable-list").sortable({
            update: function( event, ui ) {
                    var sortedIDs = $( "#sortable-list" ).sortable( "toArray" );
                    document.getElementById("orderings").value = sortedIDs;
                }
            }); 
        });

        function setOrder()
        {
            var sortedIDs = $( "#sortable-list" ).sortable( "toArray" );
            document.getElementById("orderings").value = sortedIDs;
            var form = document.getElementById("form-reoder");
            form.submit();
        }
    

</script>

<style>
        .select2-container--default .select2-selection--multiple {
            background-color: transparent;
            color: white;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: transparent;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white;
        }

        .select2-container--default .select2-search--inline .select2-search__field {
            background-color: transparent;
        }

        .select2-container {
            background: transparent;
        }

        /* Custom styles for the sleek skin */
        .vjs-sleek-skin .vjs-control-bar {
        background-color: #202020;
        }

        .vjs-sleek-skin .vjs-slider {
            background-color: #909090;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-play-progress,
        .vjs-sleek-skin .vjs-load-progress {
            background-color: #f2f2f2;
        }

        .vjs-sleek-skin .vjs-play-progress {
            height: 8px;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-load-progress {
            height: 4px;
            border-radius: 2px;
        }

        .vjs-sleek-skin .vjs-volume-bar {
            background-color: #909090;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-volume-level {
            background-color: #f2f2f2;
            border-radius: 4px;
        }

        .vjs-sleek-skin .vjs-mute-control,
        .vjs-sleek-skin .vjs-volume-menu-button {
        color: #f2f2f2;
        }

        .vjs-sleek-skin .vjs-big-play-button {
            border: none;
            height: 80px;
            width: 80px;
            margin: auto; 
            font-size: 48px;
            line-height: 80px;
            text-align: center;
        }

        .vjs-sleek-skin .vjs-big-play-button:hover {
            background-color: rgba(0, 0, 0, 0.7);
        }

        .vjs-sleek-skin .vjs-control-bar .vjs-current-time,
        .vjs-sleek-skin .vjs-control-bar .vjs-duration {
            color: #f2f2f2;
        }
</style>