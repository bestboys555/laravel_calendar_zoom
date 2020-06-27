Dropzone.autoDiscover = false;
function load_file(){ //function load()
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            cache: false,
            type: 'POST',
            dataType: "json",
            data: {
                ref_table_id: $("#table_id").val(),
                table_name: $("#table_name").val(),
                },
            url: $('#show_file').attr('route-data'),
            success: function (data) {
                $("#show_file").html(data.html_data);
                load_data_pic();
                }
            });
}

$(document).ready(function(){
    load_file();
$(document).on("click", ".stcover", function() {
    if(confirm("Confirm setting this image as the cover page?"))
    {
        var ID = $(this).attr("id");
        $.ajax({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        cache: false,
        type: "POST",
        dataType: "json",
        url: $(this).attr('route-data'),
            data: {
                    file_id: ID,
                    table_name: $("#table_name").val()
                },
        beforeSend: function(){ $("#recordsArray_"+ID).animate({'backgroundColor':'#fb6c6c'},300);},
        success: function(response){
            if(response.message=="success"){
                load_file();
            }
        }
        });
    }
    return false;
});

$(document).on("click", ".stdelete", function() {
    if(confirm("Delete this Photo?"))
    {
        var ID = $(this).attr("id");
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            cache: false,
            type: "POST",
            dataType: "json",
            url: $(this).attr('route-data'),
            data: {
                file_id: ID,
                },
            beforeSend: function(){ $("#recordsArray_"+ID).animate({'backgroundColor':'#fb6c6c'},300);},
            success: function(response){
                    if(response.message=="success"){
                        load_file();
                    }
                }
        });
    }
    return false;
});


$("#show_file").sortable({
    opacity: 0.8,
    cursor: 'move',
    tolerance: 'pointer',
    connectWith: '.col-xs-12',
    update: function() {
           var order = $("#show_file").sortable("serialize") + '&type=updateRecords&_token='+ $('meta[name="csrf-token"]').attr('content');
           $.post($(this).attr('route-data-sortable'), order, function(theResponse){
           });
       }
});

var myDropzone = new Dropzone("#myDropzone", {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: $('#myDropzone').attr('route-data'),
		type: "post",
		paramName: "pic_file",
		params: {
		 	ref_table_id: $("#table_id").val(),
            file_title: $("#name").val(),
            table_name: $("#table_name").val(),
		},
        autoProcessQueue: true,
        uploadMultiple: false, // uplaod files in a single request
        maxFilesize: 24, // MB
        acceptedFiles: ".jpg, .jpeg, .png, .gif, .pdf, .doc, .docx, .xls, .xlsx",
        // Language Strings
        dictInvalidFileType: "ประเภทไฟล์ไม่ถูกต้อง",
        dictDefaultMessage: "Upload Picture and Document file",
    });
		myDropzone.on("success", function(file,response) {
			myDropzone.removeFile(file);
			if(response.message=="success"){
                load_file();
			}
        });
});
