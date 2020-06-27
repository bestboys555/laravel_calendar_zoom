$(document).ready(function(){
$(document).on("click", ".add_images_textedit", function() {
 var url = $(this).attr('data-url');
 $('#summernote').summernote("insertImage", url, 'filename');
});

$(document).on("click", ".add_link_textedit", function() {
    var url = $(this).attr('data-url');
    var title = $(this).attr('data-title');
    $('#summernote').summernote('createLink', {
        text: title,
        url: url,
        isNewWindow: true
      });
   });

    //   // File manager button (image icon)
    //   const FMButton = function(context) {
    //     const ui = $.summernote.ui;
    //     const button = ui.button({
    //       contents: '<i class="note-icon-picture"></i> ',
    //       tooltip: 'File Manager',
    //       click: function() {
    //         window.open('/file-manager/summernote', 'fm', 'width=1400,height=800');
    //       }
    //     });
    //     return button.render();
    //   };
      $('#summernote').summernote({
        toolbar: [
            ['fil', ['undo','redo']],
            ['fil', ['hr','clear']],
            ['font', ['style','bold','italic', 'underline','superscript','subscript']],
            ['fontname', ['fontname','fontsize','color']],
            ['para', ['ul', 'ol', 'paragraph','height']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']],
        ],
        // buttons: {
        //   fm: FMButton
        // },
        height: 300,
        tabsize: 1
      });
});
    // // set file link
    // function fmSetLink(url) {
    //     var fileExtension = ['jpeg','jpg','png','gif'];
    //     if ($.inArray(url.split('.').pop().toLowerCase(), fileExtension) == -1) {
    //         $('#summernote').summernote('createLink', {
    //             text: url,
    //             url: url,
    //             isNewWindow: true
    //           });
    //     }else{
    //         $('#summernote').summernote('insertImage', url);
    //     }
    // }
