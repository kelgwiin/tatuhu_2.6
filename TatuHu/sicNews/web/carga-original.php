<html>
    <head>
        <link href="./js/uploadify-v2.1.4/uploadify.css" type="text/css" rel="stylesheet" />
        <script type="text/javascript" src="./js/uploadify-v2.1.4/jquery-1.4.2.min.js"></script>
        <script type="text/javascript" src="./js/uploadify-v2.1.4/swfobject.js"></script>
        <script type="text/javascript" src="./js/uploadify-v2.1.4/jquery.uploadify.v2.1.4.min.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
          $('#file_upload').uploadify({
            'uploader'  : './js/uploadify-v2.1.4/uploadify.swf',
            'script'    : './js/uploadify-v2.1.4/uploadify.php',
            'cancelImg' : './js/uploadify-v2.1.4/cancel.png',
            //'folder'    : './js/uploadify-v2.1.4/uploads',
            'folder'    : "./files",
            'buttonText'  : 'Select Archivos',
            'auto'      : false,
            'multi'     : true
          });
        });
        </script>

            <title></title>
            <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">      
    </head>
    <body>
        <div>
            <table>
                <tr>
                    <td>
                        <span>
                            <a href="javascript:$('#file_upload').uploadifyUpload()">Subir Archivos</a>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
        <div>
            <table>
                <tr>
                    <td>
                        <input id="file_upload" name="file_upload" type="file" />
                    </td>
                </tr>
            </table>
        </div>

    </body>
</html>


