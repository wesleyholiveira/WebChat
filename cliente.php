<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <div class="row chat-window col-xs-5 col-md-3" id="chat_window_1" style="margin-left:10px;">
            <div class="col-xs-12 col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading top-bar">
                        <div class="col-md-8 col-xs-8">
                            <h3 class="panel-title"><span class="glyphicon glyphicon-comment"></span> Chat - Miguel</h3>
                        </div>
                        <div class="col-md-4 col-xs-4" style="text-align: right;">
                            <a href="#"><span id="minim_chat_window" class="glyphicon glyphicon-minus icon_minim"></span></a>
                            <a href="#"><span class="glyphicon glyphicon-remove icon_close" data-id="chat_window_1"></span></a>
                        </div>
                    </div>
                    <div class="panel-body msg_container_base"></div>

                        <!-- 
                        Mensagem enviada
                        <div class="row msg_container base_sent">
                            <div class="col-md-10 col-xs-10">
                                <div class="messages msg_sent">
                                    <p></p>
                                    <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                                </div>
                            </div>
                            <div class="col-md-2 col-xs-2 avatar">
                                <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                            </div>
                        </div> -->

                        <!-- 
                        Mensagem recebida
                        <div class="row msg_container base_receive">
                            <div class="col-md-2 col-xs-2 avatar">
                                <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">
                            </div>
                            <div class="col-md-10 col-xs-10">
                                <div class="messages msg_receive">
                                    <p>that mongodb thing looks good, huh?
                                    tiny master db, and huge document store</p>
                                    <time datetime="2009-11-13T20:00">Timothy • 51 min</time>
                                </div>
                            </div>
                        </div> -->


                    <div class="panel-footer">
                        <form id="form-send-message">
                            <div class="input-group">
                                <input id="btn-input" type="text" class="form-control input-sm chat_input" placeholder="Write your message here..." />
                                <span class="input-group-btn">
                                    <button type="submit" class="btn btn-primary btn-sm" id="btn-chat">Enviar</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="btn-group dropup">
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-cog"></span>
                <span class="sr-only">Toggle Dropdown</span>
            </button>
            <ul class="dropdown-menu" role="menu">
                <li><a href="#" id="new_chat"><span class="glyphicon glyphicon-plus"></span> Novo</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-list"></span> Ver outras</a></li>
                <li><a href="#"><span class="glyphicon glyphicon-remove"></span> Fechar Tudo</a></li>
                <li class="divider"></li>
                <li><a href="#"><span class="glyphicon glyphicon-eye-close"></span> Invisivel</a></li>
            </ul>
        </div>
    </div>
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src"js/chat.js"></script>
    <script type="text/javascript">
        var requisicao;
        function verifiyNewMessages( timestamp )
        {
            var queryString = { 'timestamp' : timestamp };
         
            requisicao = $.post ( 'request.php' , queryString , function ( data )
            {
                var obj = data;
                var messages = obj.content.split("\r\n");
                var arr;
                var qtd = messages.length;
                if(messages[qtd-1] == "")
                    qtd--;
                if($(".msg_container_base").html().length == 0){
                    for (var i = 1; i < qtd; i++) {
                        arr = messages[i].split("--|--");
                        if(arr[1] == "client_sent"){
                            $(".msg_container_base").append(message_sent(arr[0]));
                        }else{
                            $(".msg_container_base").append(message_received(arr[0]));
                        }
                    };
                }else{
                    arr = messages[qtd - 1].split("--|--");
                    if(arr[1] == "client_sent"){
                        $(".msg_container_base").append(message_sent(arr[0]));
                    }else{
                        $(".msg_container_base").append(message_received(arr[0]));
                    }
                }
                $('.msg_container_base').animate({scrollTop:$(".msg_container_base").get(0).scrollHeight}, '500');;
                /*
                if(obj == "receive"){
                    $(".msg_container_base").append(message_received(obj.message));
                }else{
                    $(".msg_container_base").append(message_sent(obj.message));
                }*/
         
                // reconecta ao receber uma resposta do servidor
                verifiyNewMessages( obj.timestamp );
            }, "json");
        }

        function message_received(message){
            return '\
                <div class="row msg_container base_receive">\
                    <div class="col-md-2 col-xs-2 avatar">\
                        <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">\
                    </div>\
                    <div class="col-md-10 col-xs-10">\
                        <div class="messages msg_receive">\
                            <p>' + message + '</p>\
                        </div>\
                    </div>\
                </div>\
            ';
        }

        function message_sent(message){
            return '\
                <div class="row msg_container base_sent">\
                    <div class="col-md-2 col-xs-2 avatar">\
                        <img src="http://www.bitrebels.com/wp-content/uploads/2011/02/Original-Facebook-Geek-Profile-Avatar-1.jpg" class=" img-responsive ">\
                    </div>\
                    <div class="col-md-10 col-xs-10">\
                        <div class="messages msg_receive">\
                            <p>' + message + '</p>\
                        </div>\
                    </div>\
                </div>\
            ';
        }

        $(function(){
            verifiyNewMessages();

            $("#form-send-message").submit(function(){
                //requisicao.abort();
                var texto = $(".chat_input").val();
                $.post(
                    "send_message.php",
                    {message: texto, type: "client_sent"},
                    function(data){
                       $(".chat_input").val("");
                       verifiyNewMessages(data);
                    }
                );

                return false;
            });
        });
    </script>
</body>
</html>