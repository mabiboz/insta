<style>
    .swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen) > .swal2-modal {
        width: 70%;
        margin-top: 100px;

    }

    #notifyBox {
        line-height: 30px;
        padding: 30px;
    }
</style>

@php
    $contentPopup = "<p class='text-justify' id='notifyBox'>$lastNews->content</p>"
@endphp
<script>

    Swal.fire({
        title: '{{ $lastNews->title }}',
        html: "{!! $contentPopup !!}",
        confirmButtonText: 'متوجه شدم !',
        imageUrl: '{{ config("UploadPath.news_image_path").$lastNews->image }}',
        imageWidth: 400,
        imageHeight: 200,
        imageAlt: '',
        onBeforeOpen: function () {
            if (localStorage.getItem("news_{{$lastNews->id}}") === null) {
                localStorage.setItem("news_{{$lastNews->id}}", "1");
            } else {
                throw new Error("Something went badly wrong!");
            }

        },


    })
</script>