<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .dropzone{
            border: none !important;
            padding: 0 !important;
        }
        /*
        .group-dz{
            border: 1px dashed gray;
        }
        .dz-message{
            margin: 0 !important;
            padding: 2em 0;
        } */
        .upload {
		    background-color: #fbfdff;
		    border: 1px dashed #c0ccda;
		    border-radius: 6px;
		    padding: 60px;
		    text-align: center;
		    margin-bottom: 15px;
		    cursor: pointer;
		}
    </style>
</head>
<body>
    <div class="container">
        <div class="row">
            <h1>Dropzone</h1>
            <div class="col">
                <form id="formUpload" name="formUpload"  action="{{ route('dropzone.store') }}" method="post"  class="dropzone" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                      <label for="">Name</label>
                      <input type="text" name="name" id="name" class="form-control" required placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                      <label for="">Email</label>
                      <input type="text" name="email" id="email" class="form-control" required placeholder="" aria-describedby="helpId">
                    </div>
                    <div class="form-group">
                        <div class="group-dz mt-2">
                            <div id="upload" class="dz-default dz-message dz-clickable upload">
                                Sube o arrastra tus achivos aquí
                            </div>
                        </div>
                        <div class="dropzone-previews">
                            <!-- <a class="dz-remove" href="javascript:undefined;" data-dz-remove="">Remove file</a> -->
                        </div>
                    </div>
                    <!-- <div class="fallback">
                        <input name="file" type="file" multiple />
                    </div> -->
                    <div class="form-group mt-2">
                        <button class="btn btn-info" type="submit">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</body>
<script>
    // Note that the name "myDropzone" is the camelized
    // id of the form.
    var files = [];
    var user;
    let token = $('meta[name="csrf-token"]').attr('content');
    // var formData = new FormData();
    // var formData = new FormData();

    $('#inputFile').change( function(e){
                    console.log(e.target.files[0]);
                })
    Dropzone.autoDiscover = false;
    $(function(){
        var myDropzone = new Dropzone('div#upload', {
            paramName: "file",
            url: "{{ route('dropzone.savefile') }}",
            addRemoveLinks: true,
            dictRemoveFile: 'Quitar',
            acceptedFiles: 'image/*',
            autoProcessQueue: false,
            previewsContainer: 'div.dropzone-previews',
            parallelUploads: 10,
            maxFiles: 10,
            uploadMultiple: true,
            params: {
                _token: token
            },
            init: function() {
                var myDropzone = this;
    
                this.on("addedfile", file => {
                    console.log("A file has been added", file);
                    // files.push(file);
                    // formData.append('file', file);
                });
                $("form[name='formUpload']").submit( function(e) { 
                // Make sure that the form isn't actually being sent.
                    e.preventDefault();
                    // e.stopPropagation();
                    
                    URL = $('#formUpload').attr('action');
                    // formData.append('elements',$('#formUpload').serialize());
                    formData = $('#formUpload').serialize();
                    
                    console.log(formData);
                    $.ajax({
                        type: "post",
                        url: URL,
                        data: formData,
                        // processData: false,
                        // contentType: false,
                        success: function (response) {
                            console.log(response);
                            user = response.id;
                            myDropzone.processQueue();
    
                        }
                    });
    
                });
    
                // of the sending event because uploadMultiple is set to true.
                this.on("sending", function(file, xhr, formData) {
                    formData.append('user', user);
                    console.log('sending');
                // Gets triggered when the form is actually being sent.
                // Hide the success button or the complete form.
                });
                this.on("successmultiple", function(files, response) {
                    console.log('form', files);
    
                // Gets triggered when the files have successfully been sent.
                // Redirect user or notify of success.
                });
                this.on("errormultiple", function(files, response) {
                // Gets triggered when there was an error sending the files.
                // Maybe show form again, and notify user of error
                });
                this.on("uploadprogress", function(file, progress, bytesSent){
                    console.log(file);
                });
                    // First change the button to actually tell Dropzone to process the queue.
                // this.element.querySelector("button[type=submit]").addEventListener("click", function(e) {
                
            }
    
            // Configuration options go here
        });

    });
    // Dropzone.options.myGreatDropzone = { // camelized version of the `id`
    //     paramName: "file", // The name that will be used to transfer the file
    //     maxFilesize: 2, // MB
    //     accept: function(file, done) {
    //     if (file.name == "justinbieber.jpg") {
    //         done("Naha, you don't.");
    //     }
    //     else { done(); }
    //     }
    // };
</script>
</html>