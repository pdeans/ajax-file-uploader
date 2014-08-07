<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>AJAX File Uploader</title>
        <link rel="stylesheet" href="css/styles.css">
        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700' rel='stylesheet' type='text/css'>
    </head>
    <body>
        <form action="upload.php" method="post" id="uploadForm" class="upload-form" enctype="multipart/form-data">
            <fieldset>
                <legend>Upload Files</legend>
                The following file extensions are permitted:
                <br>
                <small>(.jpg, .png, .gif, .txt, .pdf, .doc, .docx, .rtf) Max file size = 300MB</small>
                <br>
                <input type="file" id="file" name="file[]" required multiple>
                <input type="submit" id="submit" name="submit" value="UPLOAD">
            </fieldset>

            <div class="pbar">
                <span id="pb" class="pbar-fill"><span id="pt" class="pbar-fill-text"></span></span>
            </div>

            <div id="uploads" class="uploads">
                Your uploaded file links will appear below:
            </div>
        </form>

        <script src="js/upload.js"></script>
        <script>
            document.getElementById('submit').addEventListener('click', function(e) {
                e.preventDefault();

                var f = document.getElementById('file'),
                   pb = document.getElementById('pb'),
                   pt = document.getElementById('pt');

                app.uploader({
                    files: f,
                    progressBar: pb,
                    progressText: pt,
                    processor: 'upload.php',
                    finished: function(data) {
                        var uploads = document.getElementById('uploads'),
                            succeeded = document.createElement('div'),
                            failed = document.createElement('div'),
                            anchor,
                            span,
                            x;

                        if(data.failed.length) {
                            failed.innerHTML = '<p>The following files failed to upload, please check file extension and/or size:</p>'
                        }

                        for(x = 0; x < data.succeeded.length; x++) {
                            anchor = document.createElement('a');
                            anchor.href = 'uploads/' + data.succeeded[x].file;
                            anchor.innerText = data.succeeded[x].name;
                            anchor.target = '_blank';

                            succeeded.appendChild(anchor);
                        }

                        for(x = 0; x < data.failed.length; x++) {
                            span = document.createElement('span');
                            span.innerText = data.failed[x].name;

                            failed.appendChild(span);
                        }

                        uploads.appendChild(succeeded);
                        uploads.appendChild(failed);
                    },
                    error: function() {
                        console.log('Error occurred!'); // Set error-handling here for production
                    }
                });
            });
        </script>
    </body>
</html>
