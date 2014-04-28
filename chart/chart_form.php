<meta charset='utf-8' />
<script src='../javascript/jquery-2.1.0.min.js'></script>
<script>
    $(function(){ 
        $("input[name='submit']").click(function(){
            var message = $('textarea[name=message]').val();
            if(message){
                $.ajax({
                    type: 'post',
                    url: 'chart_client.php',
                    data: 'message=' + message,
                    dataType: 'json',
                    success: function(result){
                        var content = result.message;
                        var html = "<div style='margin-bottom: 10px'>" + content + "</div>";
                        $('#record').append(html);
                        $('textarea[name=message]').val('');
                    }
                });
            }
        });  
    });
</script>

<div style='text-align: center; border: 1px solid red; height: 500px; width: 600px'>
    <div style='height: 350px;  border-bottom: 1px solid red' id='record'>

    </div>
    <div>
        <textarea style='height: 148px; border: 0' cols=70 rows=8 name='message'></textarea>
    </div>
    <div>
        <input name='submit' type='button' value='发送' />
    </div>
</div>