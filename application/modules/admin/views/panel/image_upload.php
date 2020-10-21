<script type="text/javascript">

jQuery('body').on({'drop dragover dragenter': dropHandler}, '[data-image-uploader]');
jQuery('body').on({'change': regularImageUpload}, '#file');

function regularImageUpload(e) {
// alert('1');
    e.preventDefault();

    var file =jQuery(this)[0],
        type = file.files[0].type.toLocaleLowerCase();

    if ($(this).data('id'))
    {
        br_id = $(this).data('id');
    }
    else{
        br_id = 0;
    }
    if(type.match(/jpg/) !== null ||
        type.match(/jpeg/) !== null ||
        type.match(/png/) !== null ||
        type.match(/gif/) !== null) {

        readUploadedImage(file.files[0],br_id);
    }
}

function dropHandler(e) {
    e.preventDefault();
// alert('0');
    if(e.type === 'drop' && e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {

        var files = e.originalEvent.dataTransfer.files,
            type = files[0].type.toLocaleLowerCase();

        if ($(this).data('id'))
        {
            br_id = $(this).data('id');
        }
        else{
            br_id = 0;
        }

        if(type.match(/jpg/) !== null ||
            type.match(/jpeg/) !== null ||
            type.match(/png/) !== null ||
            type.match(/gif/) !== null) {

            readUploadedImage(files[0],br_id);

        }

    }

    return false;
}

function readUploadedImage(img,br_id = 0) {
    var reader;
// alert('2');
    if(window.FileReader) {
        reader = new FileReader();
        reader.readAsDataURL(img);

        reader.onload = function (file) {
            if(file.target && file.target.result) {
                imageLoader(file.target.result, displayImage, br_id);
            }

        };

        reader.onerror = function () {
            throw new Error('Something went wrong!');
        };

    } else {
        throw new Error('FileReader not supported!');
    }

}

function imageLoader(src, callback, br_id) {
    var img;
// alert('3');
    img = new Image();

    img.src = src;

    img.onload = function() {
        
        var res = this.width/this.height;
        // alert(res);
        if (res >= 3 && res <= 6)
        {
            imageResizer(img, callback, br_id);
        }
        else{
            swal('','Incorrect image size.\nImage should be in 3:1 to 6:1 ratio. Now it is '+res.toFixed(2)+' : 1');
        }
        
    }

}

function imageResizer(img, callback, br_id) {
    // alert('4');
    var canvas = document.createElement('canvas');
    canvas.width = 50;
    canvas.height = 50;
    context = canvas.getContext('2d');
    context.drawImage( img, 0, 0, 50, 50 );
    callback(canvas.toDataURL(), br_id);

}

function displayImage(img, br_id) {

    if(!br_id)
    {
        $('#img_div').show();
        $('#img_loader').show();
        // $('#dis_image').hide();
        $('#choose-image').hide();
        file =jQuery("#file")[0];
    }
    else{
        $('#img_div'+br_id).show();
        $('#img_loader'+br_id).show();
        // $('#dis_image'+br_id).hide();
        $('#choose-image'+br_id).hide();
        // alert("#file"+br_id);
        file =jQuery("#file"+br_id)[0];
        console.log(file);
    }
    
    fd = new FormData();
    individual_capt = "My logo";
    fd.append("caption", individual_capt);  
    fd.append('action', 'fiu_upload_file'); 
    fd.append("file", file.files[0]);
    fd.append("path", 'admin/seller_img/');
    // fd.append("vendor", 'true');

    jQuery.ajax({
       type: 'POST',
       url: '<?php echo base_url('admin/file_handling/uploadFiless'); ?>',
       data: fd,
       contentType: false,
       cache: false,
       processData: false,
       success: function(response){
        if(!br_id)
        {
            $('#img_loader').hide();
            $('#dis_image').show();
        }
        else{
            $('#img_loader'+br_id).hide();
            $('#dis_image'+br_id).show();
        }
        
        if(response == "false"){
            swal("","Something went wrong, Please try again...");
        }else{
            // alert(br_id);
            if(!br_id)
            {
                jQuery('[data-image]').attr('src', img);
                jQuery('#file_name').val(response);
            }
            else{
                // alert('data-image-'+br_id);
                jQuery('[data-image-'+br_id+']').attr('src', img);
                jQuery('#br_file_name'+br_id).val(response);
            }
            
        }
       }
    });
}

/*----------------------------------------------------------------------------------------------------*/


/*----------------------------------------------------------------------------------------------------*/
jQuery('body').on({'drop dragover dragenter': dropHandler1}, '[data-image-uploader-gold]');
jQuery('body').on({'change': regularImageUpload1}, '#file_gold');

function regularImageUpload1(e) {
// alert('1');
    e.preventDefault();

    var file =jQuery(this)[0],
        type = file.files[0].type.toLocaleLowerCase();

    if ($(this).data('id'))
    {
        br_id = $(this).data('id');
    }
    else{
        br_id = 0;
    }
    if(type.match(/jpg/) !== null ||
        type.match(/jpeg/) !== null ||
        type.match(/png/) !== null ||
        type.match(/gif/) !== null) {

        readUploadedImage1(file.files[0],file,br_id);
    }
}

function dropHandler1(e) {
    e.preventDefault();
// alert('0');
    if(e.type === 'drop' && e.originalEvent.dataTransfer && e.originalEvent.dataTransfer.files.length) {

        var files = e.originalEvent.dataTransfer.files,
            type = files[0].type.toLocaleLowerCase();
// console.log(files);
        if ($(this).data('id'))
        {
            br_id = $(this).data('id');
        }
        else{
            br_id = 0;
        }

        if(type.match(/jpg/) !== null ||
            type.match(/jpeg/) !== null ||
            type.match(/png/) !== null ||
            type.match(/gif/) !== null) {

            readUploadedImage1(files[0],files,br_id);

        }

    }

    return false;
}

function readUploadedImage1(img,files,br_id = 0) {
    var reader;
// alert('2');
    if(window.FileReader) {
        reader = new FileReader();
        reader.readAsDataURL(img);

        reader.onload = function (file) {
            if(file.target && file.target.result) {
                imageLoader1(file.target.result, displayImage1, files, br_id);
            }

        };

        reader.onerror = function () {
            throw new Error('Something went wrong!');
        };

    } else {
        throw new Error('FileReader not supported!');
    }

}

function imageLoader1(src, callback, files, br_id) {
    var img;
// alert('3');
    img = new Image();

    img.src = src;

    img.onload = function() {
        
        var res = this.width/this.height;
        // alert(res);
        // console.log(src);
        if (res >= 1 && res <= 2)
        {
            imageResizer1(img, callback, files, br_id);
        }
        else{
            swal('','Incorrect image size.\nImage should be in 1:1 to 2:1 ratio. Now it is '+res.toFixed(2)+' : 1');
        }
        
    }

}

function imageResizer1(img, callback, files, br_id) {
    // alert('4');
    var canvas = document.createElement('canvas');
    canvas.width = 50;
    canvas.height = 50;
    context = canvas.getContext('2d');
    context.drawImage( img, 0, 0, 50, 50 );
    callback(canvas.toDataURL(), files, br_id);

}

function displayImage1(img, file, br_id) {
    // alert(display);
    if(!br_id)
    {
        $('#img_div_gold').show();
        $('#img_loader_gold').show();
        // $('#dis_image').hide();
        $('#choose-image_gold').hide();
        // file =jQuery("#file_gold")[0];
    }
    else{
        $('#img_div_gold'+br_id).show();
        $('#img_loader_gold'+br_id).show();
        // $('#dis_image'+br_id).hide();
        $('#choose-image_gold'+br_id).hide();
        // alert("#file_gold"+br_id);
        // file =jQuery("#file_gold"+br_id)[0];
        // console.log(file);
    }
    
    fd = new FormData();
    individual_capt = "My logo";
    fd.append("caption", individual_capt);  
    fd.append('action', 'fiu_upload_file'); 
    fd.append("file", file.files[0]);
    fd.append("path", 'admin/seller_img/');
    // fd.append("vendor", 'true');

    jQuery.ajax({
       type: 'POST',
       url: '<?php echo base_url('admin/file_handling/uploadFiless'); ?>',
       data: fd,
       contentType: false,
       cache: false,
       processData: false,
       success: function(response){
        if(!br_id)
        {
            $('#img_loader_gold').hide();
            $('#dis_image_gold').show();
        }
        else{
            $('#img_loader_gold'+br_id).hide();
            $('#dis_image_gold'+br_id).show();
        }
        
        if(response == "false"){
            swal("","Something went wrong, Please try again...");
        }else{
            // alert(br_id);
            if(!br_id)
            {
                jQuery('[data-image_gold]').attr('src', img);
                jQuery('#file_name_gold').val(response);
            }
            else{
                // alert('data-image-'+display+br_id);
                jQuery('[data-image-_gold'+br_id+']').attr('src', img);
                jQuery('#br_file_name_gold'+br_id).val(response);
            }
            
        }
       }
    });
}
</script>