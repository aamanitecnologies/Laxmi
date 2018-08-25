<div id="main">
    <h1>Upload Your Images</h1>
    <form method="post" enctype="multipart/form-data"  action="upload.php">
        <input type="file" name="images" id="images" multiple />
        <button type="submit" id="btn">Upload Files!</button>
    </form>
</div>

<script>
    (function () {
        var input = document.getElementById("images"),
                formdata = false;

        function showUploadedItem(source) {
            var list = document.getElementById("image-list"),
                    li = document.createElement("li"),
                    img = document.createElement("img");
            img.src = source;
            li.appendChild(img);
            list.appendChild(li);
        }

        if (window.FormData) {

            formdata = new FormData();
            formdata = new FormData();


            //document.getElementById("btn").style.display = "none";
        }

        $("#btn").click(function (evt) {


            evt.preventDefault();
            document.getElementById("response").innerHTML = "Uploading . . ."
            var i = 0, len = input.files.length, img, reader, file;

            for (; i < len; i++) {
                file = input.files[i];

                if (!!file.type.match(/image.*/)) {
                    if (window.FileReader) {
                        reader = new FileReader();
                        reader.onloadend = function (e) {
                            showUploadedItem(e.target.result, file.fileName);
                        };
                        reader.readAsDataURL(file);
                    }
                    if (formdata) {
                        formdata.append("images[]", file);
                    }
                }
            }

            if (formdata) {
                $.ajax({
                    url: "upload.php",
                    type: "POST",
                    data: formdata,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        document.getElementById("response").innerHTML = res;
                    }
                });
            }
        });
    }());

</script>
