<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/shim.min.js" integrity="sha512-nPnkC29R0sikt0ieZaAkk28Ib7Y1Dz7IqePgELH30NnSi1DzG4x+envJAOHz8ZSAveLXAHTR3ai2E9DZUsT8pQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
            $("#fileUploader").change(function(evt){
                    var selectedFile = evt.target.files[0];
                    var reader = new FileReader();
                    reader.onload = function(event) {
                        var data = event.target.result;
                        var workbook = XLSX.read(data, {
                            type: 'binary'
                        });
                        workbook.SheetNames.forEach(function(sheetName) {
                            var XL_row_object = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
                            if (XL_row_object.length > 0) {
                                document.getElementById("jsonObject").innerHTML = JSON.stringify(XL_row_object);
                            }
                          
                        })
                    };
                    reader.onerror = function(event) {
                    console.error("File could not be read! Code " + event.target.error.code);
                };
                // 读取上传文件为二进制
                reader.readAsBinaryString(selectedFile);
            });
        });
    </script>
</head>
<body>
<input type="file" id="fileUploader" name="fileUploader" accept=".xls, .xlsx"/>
    </br></br>
    JSON : <label id="jsonObject"> </label>
</script>

</body>
</html>