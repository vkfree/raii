jQuery('body').on({'drop dragover dragenter': dropHandler}, '[data-image-uploader]');
jQuery('body').on({'change': regularImageUpload}, '#file');

function regularImageUpload(e) {
    alert('hi');
    var file =jQuery(this)[0],
        type = file.files[0].type.toLocaleLowerCase();

    if(type.match(/jpg/) !== null ||
        type.match(/jpeg/) !== null ||
        type.match(/png/) !== null ||
        type.match(/gif/) !== null) {

        readUploadedImage(file.files[0]);
    }
}

function dropHandler(e) {
    alert('as');
    e.preventDefault();

    if(e.type === 'drop' && e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {

        var files = e.originalEvent.dataTransfer.files,
            type = files[0].type.toLocaleLowerCase();

        if(type.match(/jpg/) !== null ||
            type.match(/jpeg/) !== null ||
            type.match(/png/) !== null ||
            type.match(/gif/) !== null) {

            readUploadedImage(files[0]);

        }

    }

    return false;
}

function readUploadedImage(img) {
    var reader;

    if(window.FileReader) {
        reader = new FileReader();
        reader.readAsDataURL(img);

        reader.onload = function (file) {
            if(file.target && file.target.result) {
                imageLoader(file.target.result, displayImage);
            }

        };

        reader.onerror = function () {
            throw new Error('Something went wrong!');
        };

    } else {
        throw new Error('FileReader not supported!');
    }

}

function imageLoader(src, callback) {
    var img;

    img = new Image();

    img.src = src;

    img.onload = function() {
        imageResizer(img, callback);
    }

}

function imageResizer(img, callback) {
    var canvas = document.createElement('canvas');
    canvas.width = 50;
    canvas.height = 50;
    context = canvas.getContext('2d');
    context.drawImage( img, 0, 0, 50, 50 );
    callback(canvas.toDataURL());

}

function displayImage(img) {
   
    file =jQuery("#file")[0];
    fd = new FormData();
    fd.append("file", file.files[0]);
    individual_capt = "My CV";
    fd.append("caption", individual_capt);  
    fd.append('action', 'fiu_upload_file');  
    jQuery.ajax({
       type: 'POST',
       url: MyAjax.ajaxurl,
       data: fd,
       contentType: false,
       processData: false,
       success: function(response){
        if(response == "false"){
            alert("Something went wrong, Please try again...");
        }else{
            jQuery('[data-image]').attr('src', img);
            jQuery('#photo_url').val(response);
        }
       }
    });
}