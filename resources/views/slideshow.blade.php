<html>
<style>
    body {
        height: 100%;
        width: 100%;
        margin: 0;
        padding: 0;
        background-color: black;
    }

    .fixed-background {
        position: absolute;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        overflow: hidden;
    }

    .myimg {
        height: inherit;
        margin-left: auto;
        margin-right: auto;
        display: block;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.4/socket.io.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $(function () {
        var socket = io('{{env('PICS_SOCKET_SERVER')}}');
        socket.on('pics message', function (msg) {
            location.reload();
        });
    });
</script>

<body>
    <div class="fixed-background">
        <img src="/image/current" class="myimg" />
    </div>
</body>

</html>
